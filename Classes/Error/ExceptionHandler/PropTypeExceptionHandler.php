<?php

namespace PackageFactory\AtomicFusion\PropTypes\Error\ExceptionHandler;

use Neos\Error\Messages\Error;
use Neos\Flow\Annotations as Flow;
use Neos\Fusion\Core\ExceptionHandlers\BubblingHandler;
use PackageFactory\AtomicFusion\PropTypes\Error\Exception\PropTypeException;
use Psr\Log\LoggerInterface;
use Neos\Flow\Log\ThrowableStorageInterface;

class PropTypeExceptionHandler extends BubblingHandler
{

    /**
     * @var LoggerInterface
     * @Flow\Inject
     */
    protected $systemLogger;

    /**
     * @var ThrowableStorageInterface
     * @Flow\Inject
     */
    protected $throwableStorage;

    /**
     * Whether or not to render technical details (i.e. the Fusion stacktrace) in the exception message
     *
     * @var bool
     */
    private $renderTechnicalDetails;

    /**
     * @param bool $renderTechnicalDetails whether or not to render technical details (i.e. the Fusion stacktrace) in the exception message
     */
    public function __construct(bool $renderTechnicalDetails = true)
    {
        $this->renderTechnicalDetails = $renderTechnicalDetails;
    }

    /**
     * In all aspects other than handling of PropTypeException this behaves
     * exactly as the BubblingHandler which is the internal fusion exception handler
     * by default.
     *
     * @param array $fusionPath
     * @param \Exception $exception
     * @return string
     * @throws \Neos\Flow\Configuration\Exception\InvalidConfigurationException
     * @throws \Neos\Flow\Mvc\Exception\StopActionException
     */
    public function handleRenderingException($fusionPath, \Exception $exception)
    {
        if ($exception instanceof PropTypeException) {
            return $this->handlePropTypeException($fusionPath, $exception, $exception->getReferenceCode());
        } else {
            parent::handleRenderingException($fusionPath, $exception);
        }
    }

    /**
     * Renders the exception in HTML for display
     *
     * @param string $fusionPath path causing the exception
     * @param \Exception $exception exception to handle
     * @param integer $referenceCode
     * @return string
     */
    protected function handlePropTypeException($fusionPath, PropTypeException $exception, $referenceCode)
    {
        $messageBody = sprintf('<p class="neos-message-content">%s</p>', htmlspecialchars($exception->getMessage()));

        if ($this->renderTechnicalDetails) {
            $result = $exception->getResult();
            if ($result && $result->hasErrors()) {
                $errors = $result->getFlattenedErrors();
                $renderedErrors = [];
                foreach ($errors as $path => $pathErrors) {
                    foreach ($pathErrors as $error) {
                        $renderedErrors[] = sprintf('%s: %s', $path, $error->render());
                    }
                }
                $messageBody .= sprintf('<p class="neos-message-stacktrace">The following errors were detected:<br/><code style="white-space: pre-wrap"> - %s</code></p>', implode(chr(10) . ' - ', $renderedErrors));
                $messageBody .= sprintf('<p class="neos-message-stacktrace"><code>FusionPath: %s</code></p>', htmlspecialchars($fusionPath));

            }
        }

        if ($referenceCode) {
            $messageBody .= sprintf('<p class="neos-reference-code">%s</p>', $this->formatErrorCodeMessage($referenceCode));
        }

        $message = sprintf(
            '<div class="neos-message-header"><div class="neos-message-icon"><i class="icon-warning-sign"></i></div><h1>An exception was thrown while Neos tried to render your page</h1></div>' .
            '<div class="neos-message-wrapper">%s</div>',
            $messageBody
        );

        $logMessage = $this->throwableStorage->logThrowable($exception);
        $this->systemLogger->info($logMessage);

        return $message;
    }

    /**
     * Renders a message depicting the user where to find further information
     * for the given reference code.
     *
     * @param integer $referenceCode
     * @return string A rendered message with the reference code containing HTML
     */
    protected function formatErrorCodeMessage($referenceCode)
    {
        return ($referenceCode ? 'For a full stacktrace, open <code>Data/Logs/Exceptions/' . $referenceCode . '.txt</code>' : '');
    }
}
