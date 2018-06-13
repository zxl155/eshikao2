jQuery.extend(jQuery.validator.messages, {
  required: "必填",
  remote: "请修正该字段",
  email: "请输入正确格式的电子邮件",
  url: "请输入合法的网址",
  date: "请输入合法的日期",
  dateISO: "请输入合法的日期 (ISO).",
  number: "请输入合法的数字",
  digits: "只能输入整数",
  creditcard: "请输入合法的信用卡号",
  equalTo: "请再次输入相同的值",
  accept: "请输入拥有合法后缀名的字符串",
  maxlength: jQuery.validator.format("请输入一个 长度最多是 {0} 的字符串"),
  minlength: jQuery.validator.format("请输入一个 长度最少是 {0} 的字符串"),
  rangelength: jQuery.validator.format("请输入 一个长度介于 {0} 和 {1} 之间的字符串"),
  range: jQuery.validator.format("请输入一个介于 {0} 和 {1} 之间的值"),
  max: jQuery.validator.format("请输入一个最大为{0} 的值"),
  min: jQuery.validator.format("请输入一个最小为{0} 的值")
});
jQuery.validator.addMethod("telphoneValid", function(value, element) {
    var tel = /^(130|131|132|133|134|135|136|137|138|139|150|153|157|158|159|180|187|188|189)\d{8}$/;
    return tel.test(value) || this.optional(element);
}, "请输入正确的手机号码");
jQuery.validator.addMethod('dateMinNow',function(value, element){
    var nowTime = new Date();
    nowTime.setHours(0);
    nowTime.setMinutes(0);
    nowTime.setSeconds(0);
    var time = new Date(value.split(' ')[0]);
    if(time.getTime()<nowTime.getTime()){
      return this.optional(element);
    }
    return true;
}, "输入的日期不能小于当天!");
