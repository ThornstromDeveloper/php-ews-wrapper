<?php
namespace amirsanni\phpewswrapper;

use jamesiarmes\PhpEws\Type\CalendarEventDetails;
use jamesiarmes\PhpEws\Type\CalendarEvent;
use jamesiarmes\PhpEws\Request\CreateItemType;
use jamesiarmes\PhpEws\Enumeration\CalendarItemCreateOrDeleteOperationType;
use jamesiarmes\PhpEws\ArrayType\NonEmptyArrayOfAllItemsType;
use jamesiarmes\PhpEws\Type\CalendarItemType;
use jamesiarmes\PhpEws\ArrayType\NonEmptyArrayOfAttendeesType;
use jamesiarmes\PhpEws\Enumeration\BodyTypeType;
use jamesiarmes\PhpEws\Type\BodyType;
use jamesiarmes\PhpEws\Type\AttendeeType;
use jamesiarmes\PhpEws\Type\EmailAddressType;
use jamesiarmes\PhpEws\Enumeration\RoutingType;

class Events{
    private $ews;
    private $request;
    public $event_start;
    public $event_end;
    public $timezone;
    public $location;
    public $subject;
    public $event_body;
    public $invitees;

    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */

    public function __construct($ews_client){
        $this->ews = $ews_client;
    }

    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */

    public function create(){        
        // Build the request,
        $this->request = new CreateItemType();
        $this->request->SendMeetingInvitations = CalendarItemCreateOrDeleteOperationType::SEND_TO_ALL_AND_SAVE_COPY;//SEND_ONLY_TO_ALL
        $this->request->Items = new NonEmptyArrayOfAllItemsType();

        // Build the event to be added.
        $event = new CalendarItemType();
        $event->RequiredAttendees = new NonEmptyArrayOfAttendeesType();
        $event->Subject = $this->subject;
        $event->Location = $this->location;
        $event->BusyType = "Busy";

        //Set timezone
        $this->timezone ? date_default_timezone_set($this->timezone) : '';
        $event->Start = (new \DateTime($this->event_start))->format('c');
        $event->End = (new \DateTime($this->event_end))->format('c');

        // Set the event body.
        $event->Body = new BodyType();
        $event->Body->_ = $this->event_body;
        $event->Body->BodyType = BodyTypeType::HTML;

        // Add invitees if there are any
        if($this->invitees){
            foreach($this->invitees as $invitee) {
                $attendee = new AttendeeType();
                $attendee->Mailbox = new EmailAddressType();
                $attendee->Mailbox->EmailAddress = $invitee['email'];
                $attendee->Mailbox->Name = $invitee['name'];
                $attendee->Mailbox->RoutingType = RoutingType::SMTP;
                $event->RequiredAttendees->Attendee[] = $attendee;
            }
        }

        // Add the event to the request.
        $this->request->Items->CalendarItem[] = $event;
        
        print_r($this->ews->CreateItem($this->request));
    }
}