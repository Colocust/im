export function checkPhone(phone) {
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

export function checkPassword(password) {
  let res = {
    code: 0,
    msg: '验证成功'
  };
  if (password === '') {
    res.code = 1;
    res.msg = '请输入密码'
  }
  return res
}

export function checkCaptcha(captcha) {
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

export function getDate(timestamp) {
  let date = new Date(timestamp);
  let MM = date.getMonth() + 1;
  MM = MM < 10 ? ('0' + MM) : MM;
  let d = date.getDate();
  d = d < 10 ? ('0' + d) : d;
  let h = date.getHours();
  h = h < 10 ? ('0' + h) : h;
  let m = date.getMinutes();
  m = m < 10 ? ('0' + m) : m;
  return MM + '-' + d + ' ' + h + ':' + m;
}

export default {
  checkCaptcha,
  checkPassword,
  checkPhone,
  getDate,
}
