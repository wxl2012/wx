/**
 * 是否邮箱地址
 *
 * @param value     待检测字符串
 * @returns {boolean}
 */
function isEmail(value) {
    var _emailReg = /^([a-zA-Z0-9_\.\-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
    return _emailReg.test(value);
}

/**
 * 是否手机号
 *
 * @param value     待检测字符串
 * @returns {boolean}
 */
function isPhone(value) {
    var _phoneReg = /((\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$)|(^(0|86|17951)?(13[0-9]|15[012356789]|18[0-9]|14[57]|170)[0-9]{8}$)/;
    return _phoneReg.test(value);
}