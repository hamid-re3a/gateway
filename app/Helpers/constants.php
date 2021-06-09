<?php


/**
 * user_roles
 */
const USER_ROLE_ADMIN = 'admin';
const USER_ROLE_CLIENT = 'client';
const USER_ROLE_HELP_DESK = 'help-desk';
const USER_ROLES = [
    USER_ROLE_ADMIN,
    USER_ROLE_CLIENT,
    USER_ROLE_HELP_DESK,
];

/**
 * Ticket_status
 */

const TICKET_ANSWERED = 'ANSWERED';
const TICKET_NOT_ANSWERED = 'NOT_ANSWERED';
const TICKET_IN_PROGRESS = 'IN_PROGRESS';
const TICKET_SPAM = 'SPAM';
const TICKET_STATUS = [
    TICKET_ANSWERED,
    TICKET_NOT_ANSWERED,
    TICKET_IN_PROGRESS,
    TICKET_SPAM
];
