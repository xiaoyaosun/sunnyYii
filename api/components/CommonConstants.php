<?php

namespace api\components;


class CommonConstants {

     const STATUS_ACTIVE = 'active';
     const STATUS_INVALID = 'invalid';
    const STATUS_CANCEL = 'cancelled';
    const STATUS_FINISH = 'finish';

    const STATUS_DELETED = 'deleted';

    const  STATUS_VERIFIED = 'verified';
    const  STATUS_REFUSED = 'refused';

    const ACTION_JOIN = 'join';
    const ACTION_REJECT = 'reject';
    const ACTION_ORGANIZE = 'organize';
    const ACTION_QUIT = 'quit';
    const ACTION_INVITE = 'invite';
    const ACTION_CANCEL = 'cancel';

    const ACTION_VERIFIED = 'verified';
    const ACTION_APPLY = 'apply';
    const ACTION_REFUSED = 'refused';

    const INVITE_ACTION_LIKE = 1;
    const INVITE_ACTION_UNLIKE = 0;

    const BLOG_ITEM_TYPE_PRIVATE = 'private';
    const BLOG_ITEM_TYPE_PUBLIC = 'public';
    const BLOG_ITEM_TYPE_EVENT = 'event';
    const BLOG_ITEM_TYPE_ALL = 'all';


    const INBOX_TYPE_INVITE = 'invite';


} 