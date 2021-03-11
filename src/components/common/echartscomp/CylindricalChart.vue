<template>
  <div>
    <div class="cylindcontainer">
      <div class="infobox">年龄分布</div>
      <div id="main" style="width: 284px; height: 200px"></div>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    myEcharts() {
      // 基于准备好的dom，初始化echarts实例
      var myChart = this.$echarts.init(document.getElementById("main"));
      // 指定图表的配置项和数据
      let data = [
        {
          code: "18岁以下",
          stock: "",
          fundPost: "21",
        },
        {
          code: "19-24岁",
          stock: "",
          fundPost: "20",
        },
        {
          code: "25-34岁",
          stock: "",
          fundPost: "19",
        },
        {
          code: "35-44岁",
          stock: "",
          fundPost: "18",
        },
        {
          code: "55以上",
          stock: "",
          fundPost: "17",
        },
       
      ];

   
      var attackSourcesColor = [
        new this.$echarts.graphic.LinearGradient(0, 1, 1, 1, [
          {
            offset: 0,
            color: "#EB3B5A",
          },
          {
            offset: 1,
            color: "#FE9C5A",
          },
        ]),
        new this.$echarts.graphic.LinearGradient(0, 1, 1, 1, [
          {
            offset: 0,
            color: "#FA8231",
          },
          {
            offset: 1,
            color: "#FFD14C",
          },
        ]),
        new this.$echarts.graphic.LinearGradient(0, 1, 1, 1, [
          {
            offset: 0,
            color: "#F7B731",
          },
          {
            offset: 1,
            color: "#FFEE96",
          },
        ]),
        new this.$echarts.graphic.LinearGradient(0, 1, 1, 1, [
          {
            offset: 0,
            color: "#395CFE",
          },
          {
            offset: 1,
            color: "#2EC7CF",
          },
        ]),
      ];
      
      var attaData = [];
      var attaName = [];
      var topName = [];
      data.forEach((it, index) => {
        attaData[index] = parseFloat(it.fundPost);
        attaName[index] = it.stock;
        topName[index] = `${it.code} ${it.stock}`;
      });
      var salvProMax = []; //背景按最大值
      for (let i = 0; i < attaData.length; i++) {
        salvProMax.push(attaData[0]);
      }

      function attackSourcesDataFmt(sData) {
        var sss = [];
        sData.forEach(function (item, i) {
          let itemStyle = {
            color: i > 3 ? attackSourcesColor[3] : attackSourcesColor[i],
          };
          sss.push({
            value: item,
            itemStyle: itemStyle,
          });
        });
        return sss;
      }

      var option = {
        //backgroundColor: "#000",
        tooltip: {
          show: false,
          backgroundColor: "rgba(3,169,244, 0.5)", //背景颜色（此时为默认色）
          textStyle: {
            fontSize: 16,
          },
        },
        color: ["#F7B731"],
        // legend: {
        //   pageIconSize: [12, 12],
        //   itemWidth: 20,
        //   itemHeight: 10,
        //   textStyle: {
        //     //图例文字的样式
        //     fontSize: 10,
        //     color: "#fff",
        //   },
        //   selectedMode: false,
        //   data: ["个人所得(亿元)"],
        // },
        grid: {
          left: "6%",
          width: "100%",
          bottom: "2%",
          top: "8%",
          containLabel: false,
        },
        xAxis: {
          type: "value",
          splitLine: {
            show: false,
          },
          axisLabel: {
            show: false,
          },
          axisTick: {
            show: false,
          },
          axisLine: {
            show: false,
          },
        },
        yAxis: [
          {
            //名称
            type: "category",
            offset: -10,
            position: "left",
            axisLabel: {
              color: `#fff`,
              fontSize: 10,
            },
            axisLine: {
              show: false,
            },
            inverse: false,
            axisTick: {
              show: false,
            },
            axisLabel: {
              interval: 0,
              color: ["#fff"],
              align: "left",
              verticalAlign: "bottom",
              lineHeight: 32,
              fontSize: 10,
            },
            data: topName,
          },
          //右侧文字
          {
            //名称
            type: "category",
            offset: -80,
            position: "right",
            axisLabel: {
              color: `#fff`,
              fontSize: 18,
            },
            axisLine: {
              show: false,
            },
            inverse: false,
            axisTick: {
              show: false,
            },
            axisLabel: {
              interval: 0,
              color: ["#FE9C5A"],
              align: "left",
              verticalAlign: "bottom",
              lineHeight: 32,
              fontSize: 16,
              fontWeight:600
            },
            data: attaData,
          },
        ],
        series: [
          {
            zlevel: 1,
            name: "",
            type: "bar",
            barWidth: "5px",
            animationDuration: 1500,
            data: attackSourcesDataFmt(attaData),
            align: "center",
            itemStyle: {
              normal: {
                barBorderRadius: 10,
              },
            },
            label: {
              show: false,
              fontSize: 10,
              color: "#fff",
              textBorderWidth: 2,
              padding: [2, 0, 0, 0],
            },
          },
          {
            name: "",
            type: "bar",
            barWidth: 5,
            barGap: "-100%",
            margin: "20",
            data: salvProMax,
            textStyle: {
              //图例文字的样式
              fontSize: 10,
              color: "#fff",
            },
            itemStyle: {
              normal: {
                color: "#05325F",
                //width:"100%",
                fontSize: 10,
                barBorderRadius: 30,
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

<style scoped>
.cylindcontainer {
  height: 219px;
  width: 284px;
  background-color: #363b4a;
  border-radius: 8px;
}
.infobox {
  background-color: #1a1e29;
  height: 17px;
  border-radius: 30px;
  text-align: center;
  font-size: 11px;
  font-weight: normal;
  font-stretch: normal;
  letter-spacing: 0px;
  color: #1171f7;
}
</style>