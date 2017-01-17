<?php

namespace api\components;


class ErrorCode {

    const ERROR_CODE_NONE = 0;

    //数据获取失败---原因不知道
    const ERROR_CODE_GENERIC_ERROR = 100;

    //数据保存失败,很有可能数据模型填值不正确，比如必填项为空
    const ERROR_CODE_SAVE_FAILED = 101;

    //用户token无效
    const ERROR_CODE_INVALID_ACCESS_TOKEN = 102;

    //无效的ID(event id, blog id。。。)
    const ERROR_CODE_INVALID_ID = 103;

    //无权操作 -- 比如不是组织者，不是成员
    const ERROR_CODE_NO_PERMISSION = 104;

    //没有post回来正确的数据,或者没有数据
    const ERROR_CODE_WITHOUT_DATA = 105;

    //约的用户操作信息丢失
    const ERROR_CODE_INVITE_DATA_MISSING = 106;

    //约的用户操作信息更新失败
    const ERROR_CODE_UPDATE_USER_INVITE_FAILED = 107;

    //取消约失败
    const ERROR_CODE_CANCEL_FAILED = 108;

    //取消约失败
    const ERROR_CODE_QUIT_FAILED = 109;

    //数据删除失败
    const ERROR_CODE_DELETE_FAILED = 110;

} 