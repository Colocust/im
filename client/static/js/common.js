

export function checkPhone (phone) {
  let res = {
    code: 0,
    msg: '验证成功'
  }
  let reg = /^[1][3,4,5,7,8][0-9]{9}$/
  if (!reg.test(phone)) {
    res.code = 1
    res.msg = '请输入正确的手机号'
  }
  return res
}

export function checkPassword (password) {
  let res = {
    code: 0,
    msg: '验证成功'
  };
  if (password === '') {
    res.code = 1
    res.msg = '请输入密码'
  }
  return res
}

export function checkCaptcha (captcha) {
  let res = {
    code: 0,
    msg: '验证成功'
  };
  if (captcha === '') {
    res.code = 1
    res.msg = '请输入验证码'
  }
  return res
}

export default {
  checkCaptcha,
  checkPassword,
  checkPhone
}
