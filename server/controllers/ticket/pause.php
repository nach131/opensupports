<?php
use Respect\Validation\Validator as DataValidator;
DataValidator::with('CustomValidations', true);

/**
 * @api {post} /ticket/pause Pause a ticket
 * @apiVersion 4.8.0
 *
 * @apiName Pause ticket
 *
 * @apiGroup Ticket
 *
 * @apiDescription This path pauses a ticket.
 *
 * @apiPermission user
 *
 * @apiParam {Number} ticketNumber The number of the ticket to pause.
 *
 * @apiUse NO_PERMISSION
 * @apiUse INVALID_TICKET
 *
 * @apiSuccess {Object} data Empty object
 *ulp d
 */

class PauseController extends Controller {
    const PATH = '/pause';
    const METHOD = 'POST';

    public function validations() {
        return [
            'permission' => 'user',
            'requestData' => [
                'ticketNumber' => [
                    'validation' => DataValidator::validTicketNumber(),
                    'error' => ERRORS::INVALID_TICKET
                ]
            ]
        ];
    }

    public function handler() {
        $user = Controller::getLoggedUser();
        $ticket = Ticket::getByTicketNumber(Controller::request('ticketNumber'));
        $ticketAuthor = $ticket->authorToArray();

        // if($ticket->owner) {
        //     throw new RequestException(ERRORS::NO_PERMISSION);
        // }

        // if(Controller::isStaffLogged() && $user->level < 3 && ($user->email !== $ticketAuthor['email'])) {
        //     throw new RequestException(ERRORS::NO_PERMISSION);
        // }

        // if(!Controller::isStaffLogged() && ($user->email !== $ticketAuthor['email'] || $ticketAuthor['staff'])) {
        //     throw new RequestException(ERRORS::NO_PERMISSION);
        // }

        // $ticket->delete();
        $this->addPauseEvent();
        $this->ticket->closed = false;
        $this->ticket->store();

        Log::createLog('PAUSE', $this->ticket->ticketNumber);

        Response::respondSuccess();
    }

    private function addPauseEvent() {
        echo 'addPauseEvent' . PHP_EOL;
        echo 'Ticketevent::PAUSE --- ' . Ticketevent::PAUSE . PHP_EOL;
        echo 'Ticketevent::CLOSE --- ' . Ticketevent::CLOSE . PHP_EOL;
        
        $event = Ticketevent::getEvent(Ticketevent::PAUSE);
        $event->setProperties(array(
            'date' => Date::getCurrentDate()
        ));

        if(Controller::isStaffLogged()) {
            $event->authorStaff = Controller::getLoggedUser();
        } else {
            $event->authorUser = Controller::getLoggedUser();
        }

        $this->ticket->addEvent($event);
    }


}
