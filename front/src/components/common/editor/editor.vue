<template>
  <div class="editor">
    <div id="e" >
    </div>
  </div>
</template>

<script>
  import E from "wangeditor"
  export default {
    name: 'editor',
    data(){
      return{
        content:"",
        editor: null,
        info_:null
      }
    },
    model: {
      prop: 'desc',
      event:'change'
    },
    watch:{
      isClear(val){
       // console.log(val)
        if (val){
          this.editor.txt.clear()
         // this.info_=null
        }
      },
      desc(value) {
        //console.log("desc",value)
        if (value != this.editor.txt.html()) {
          this.editor.txt.html(this.desc)
        }
      }
    },
    props:{
      desc:{
        type:String,
        default:""
      },
 //业务中我们经常会有添加操作和编辑操作，添加操作时，我们需清除上一操作留下的缓存
      isClear:{
        type:Boolean,
        default:false
      }
    },

    methods:{
      initE(){
        this.editor = new E('#e')
        this.editor.config.onchangeTimeout = 1000 // 单位 ms
        this.editor.config.uploadFileName = 'Filedata'
        this.editor.config.uploadImgServer = `/back/gthmmc/gthmmc/index.php?m=amobiletour&c=uploadWeb&a=imageUpload`  // 你的服务器地址
        this.editor.config.uploadImgHooks = {
          before: function (xhr, editor, files) {
              
            // 图片上传之前触发
            // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象，files 是选择的图片文件

            // 如果返回的结果是 {prevent: true, msg: 'xxxx'} 则表示用户放弃上传
            // return {
            //     prevent: true,
            //     msg: '放弃上传'
            // }
          },
          success: function (xhr, editor, result) {
            // 图片上传并返回结果，图片插入成功之后触发
            // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象，result 是服务器端返回的结果
          },
          fail: function (xhr, editor, result) {
            // 图片上传并返回结果，但图片插入错误时触发
            // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象，result 是服务器端返回的结果
          },
          error: function (xhr, editor) {
            // 图片上传出错时触发
            // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象
          },
          timeout: function (xhr, editor) {
            // 图片上传超时时触发
            // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象
          },

          // 如果服务器端返回的不是 {errno:0, data: [...]} 这种格式，可使用该配置
          // （但是，服务器端返回的必须是一个 JSON 格式字符串！！！否则会报错）
          customInsert: function (insertImg, result, editor) {
            // 图片上传并返回结果，自定义插入图片的事件（而不是编辑器自动插入图片！！！）
            // insertImg 是插入图片的函数，editor 是编辑器对象，result 是服务器端返回的结果

            // 举例：假如上传图片成功后，服务器端返回的是 {url:'....'} 这种格式，即可这样插入图片：
            console.log(result.path)
            var url = '/back/gthmmc'+result.path
            insertImg(url)

            // result 必须是一个 JSON 格式字符串！！！否则报错
          }
        }
        this.editor.config.onchange = (html) => {
          this.info_ = html // 绑定当前逐渐地值
          //console.log( this.info_);
          this.$emit('change', this.info_) // 将内容同步到父组件中
        }
       
        this.editor.create()
        this.editor.txt.html(this.desc)
      //  this.editor.txt.html(this.desc)
        }
    },
    mounted () {
      this.initE();
      //console.log(this.desc);
    }
  }
</script>

<style scoped>

</style>