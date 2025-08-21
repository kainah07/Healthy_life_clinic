// Bar chart: Show total appointments per month
var barChart = echarts.init(document.getElementById('bar-chart-monthly'));
barChart.setOption({
  tooltip: {
    trigger: 'axis',
    axisPointer: { type: 'shadow' }
  },
  grid: { left: '3%', right: '4%', bottom: '1%', top: '10%', containLabel: true },
  xAxis: {
    type: 'category',
    data: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
    axisTick: { alignWithLabel: true }
  },
  yAxis: {
    type: 'value'
  },
  series: [{
    name: 'Appointments',
    type: 'bar',
    barWidth: '40%',
    data: monthlyData
  }]
});

// Line chart: Show total appointment per day for current week and last week
var lineChart = echarts.init(document.getElementById('line-chart'));
lineChart.setOption({
color: ['#00c853', '#ff9800'],
  tooltip: {
    trigger: 'axis'
  },
  legend: {
    top: 0,
    data: ['This Week', 'Last Week']
  },
  grid: {
    left: '1%',
    right: '4%',
    top: '15%',
    bottom: '3%',
    containLabel: true
  },
  xAxis: {
    type: 'category',
    boundaryGap: false,
    data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
  },
  yAxis: {
    type: 'value'
  },
  series: [
    {
      name: 'This Week',
      type: 'line',
      smooth: true,
      stack: 'Total',
      data: thisWeekData,
      lineStyle: {
        width:5
      }
    },
    {
      name: 'Last Week',
      type: 'line',
      smooth: true,
      stack: 'Total',
      data: lastWeekData,
      lineStyle: {
        width: 5
      },
    }
  ]
});


// Pie chart: Show services with the most appointments
var pieChart = echarts.init(document.getElementById('pie-chart'));
pieChart.setOption({
  tooltip: {
      trigger: 'item',
      formatter: '{b}: {c}'
    },
  legend: {
    bottom: '1%',
    left: 10, 
    orient: 'vertical',
    itemWidth: 25,
    itemHeight: 12,
    textStyle: {
      fontSize: 12
    }
  },
  series: [
    {
      name: 'Access From',
      type: 'pie',
      radius: ['40%', '60%'],
      center: ['50%', '32%'],
      avoidLabelOverlap: false,
      itemStyle: {
        borderRadius: 1,
        borderColor: '#fff',
        borderWidth: 2
      },
      label: {
        show: true,
        position: 'inside',
        formatter: '{d}%',
        fontSize: 12
      },
      emphasis: {
        label: {
          show: true,
          fontSize: 14,
          fontWeight: 'bold'
        }
      },
      labelLine: {
        show: false
      },
      data: serviceData,
    }
  ]    
});