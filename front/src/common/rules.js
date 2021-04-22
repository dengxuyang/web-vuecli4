export const CleanDataManageRules = {
        mould_name: [
            { required: true, message: "请输入名称！", trigger: "blur" },
        ],
        mould_table: [
            { required: true, message: "请输入网址！", trigger: "blur" },
        ],
        is_enable: [
            { required: true, message: "请选择状态！", trigger: "change" },
        ],
    }
export function  isNum(rule, value, callback) {
    const age = /^[0-9]*$/;
    if (value) {
      if (!age.test(value)) {
        callback(new Error("只能输入数字"));
      } else {
        callback();
      }
    } else {
      callback();
    }
  }