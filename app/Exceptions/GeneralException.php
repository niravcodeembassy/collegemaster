<?php

namespace App\Exceptions;

use App\Mail\ExceptionMail;
use Throwable;
use Mail;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\ErrorHandler\ErrorHandler as SymfonyExceptionHandler;
use Exception;

/**
 * Class GeneralException.
 */
class GeneralException extends Exception
{
    /**
     * @var
     */
    public $message;

    /**
     * GeneralException constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Report the exception.
     */
    public function report(Exception $exception)
    {
        dd($exception);
        $this->sendEmail($exception); // sends an email
        // parent::report($exception);
    }


    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        // All instances of GeneralException redirect back with a flash message to show a bootstrap alert-error
        return redirect()
            ->back()
            ->with('erorr', 'Paymet Fail')
            ->withInput()
            ->withFlashDanger($this->message);
    }

    public function sendEmail(Expect $exception)
    {

        try {
            $e = FlattenException::create($exception);
            $handler = new SymfonyExceptionHandler();
            $html = $handler->getHtml($e);
            Mail::to('developer@gmail.com')->send(new ExceptionMail($html));
        } catch (Throwable $ex) {
        }
    }
}
