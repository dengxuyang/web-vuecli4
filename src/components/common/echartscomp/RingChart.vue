<template>
  <div class="Echarts">
    <div id="main1" style="width: 300px; height: 200px"></div>
  </div>
</template>

<script>
export default {
  name: "Echarts",
  methods: {
    myEcharts() {
      // 基于准备好的dom，初始化echarts实例
      var myChart = this.$echarts.init(document.getElementById("main1"));

      // 指定图表的配置项和数据
      var getvalue = [2580];

      var option = {
        title: {
          text: "{a|}" + "   男性",
          textStyle: {
            color: "#ffffff",
            fontSize: 12,
            rich: {
              a: {
                // 这样设定 backgroundColor 就可以是图片了。
                align: "left",
                backgroundColor: {
                  image: require("@/assets/images/manicon.png"),
                },
                right: 5,
                verticalAlign: "middle",
                // 可以只指定图片的高度，从而图片的宽度根据图片的长宽比自动得到。
                height: 43,
                width: 17,
              },
            },
          },
          subtext:"{a|"+' '+getvalue+"}"+ "   人",
          subtextStyle: {
            color: "#1171f7",
            fontSize: 18,
            fontFamily: "PFDinTextCondPro-Medium",
            align: "middle",
            rich: {
              a: {
                // 这样设定 backgroundColor 就可以是图片了。
                color: "#1171f7",
                fontSize: 34,
                fontFamily: "PFDinTextCondPro-Medium",
                right: 5,
                width:62,
                height:24,
                fontWeight:600
                // 可以只指定图片的高度，从而图片的宽度根据图片的长宽比自动得到。
              },
            },
            // fontWeight:'blod'
          },
          itemGap: 20,
          left: "center",
          top: "23%",
        },
        // tooltip: {
        //   formatter: function (params) {
        //     return (
        //       '<span style="color: #fff;">综合得分：' + getvalue + "分</span>"
        //     );
        //   },
        // },
        angleAxis: {
          max: 9147,
          clockwise: true, // 逆时针
          // 隐藏刻度线
          show: false,
        },
        radiusAxis: {
          type: "category",
          show: true,
          axisLabel: {
            show: false,
          },
          axisLine: {
            show: false,
          },
          axisTick: {
            show: false,
          },
        },
        polar: {
          center: ["50%", "50%"],
          radius: "145%", //图形大小
        },
        series: [
          {
            type: "bar",
            data: getvalue,
            showBackground: true,
            backgroundStyle: {
              color: "#282c39",
            },
            coordinateSystem: "polar",
            roundCap: true,
            barWidth: 10,
            itemStyle: {
              normal: {
                opacity: 1,
                color: new this.$echarts.graphic.LinearGradient(0, 0, 0, 1, [
                  {
                    offset: 0,
                    color: "#1171f7",
                  },
                  {
                    offset: 1,
                    color: "#5284DE",
                  },
                ]),
                shadowBlur: 0,
                shadowColor: "#2A95F9",
              },
            },
          },
        ],
      };

      // 使用刚指定的配置项和数据显示图表。
      myChart.setOption(option);
    },
  },
  mounted() {
    this.myEcharts();
  },
};
</script>

<style>
</style>
