const textColor = '#a5a5a5ff';
// Bar chart: Show total appointments per month
var barChart = echarts.init(document.getElementById('bar-chart-monthly'));
barChart.setOption({
  color: ['#3572EF'],
  tooltip: {
    trigger: 'axis',
    axisPointer: { type: 'shadow' }
  },
  grid: { left: '3%', right: '4%', bottom: '1%', top: '10%', containLabel: true },
  xAxis: {
    type: 'category',
    data: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
    axisTick: { alignWithLabel: true },
    axisLabel : {color: textColor}
  },
  yAxis: {
    type: 'value',
    axisLabel : {color: textColor}
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
color: ['#3572EF', '#050C9C'],
  tooltip: {
    trigger: 'axis'
  },
  legend: {
    top: 0,
    data: ['This Week', 'Last Week'],
    textStyle: {color: textColor}
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
    data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
    axisLabel : {color: textColor}
  },
  yAxis: {
    type: 'value',
    axisLabel : {color: textColor}
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
  color: ['#050C9C', '#004ee9ff', '#16b1f8ff', '#6cd5ffff', '#A7E6FF'],
  tooltip: {
      trigger: 'item',
      formatter: '{b}: {c}'
    },
  legend: {
    bottom: '0%',
    left: 10, 
    orient: 'vertical',
    itemWidth: 25,
    itemHeight: 12,
    textStyle: {
      fontSize: 12,
      color: textColor
    }
  },
  series: [
    {
      name: 'Access From',
      type: 'pie',
      radius: ['35%', '60%'],
      center: ['50%', '30%'],
      avoidLabelOverlap: false,
      itemStyle: {
        borderRadius: 1,
        borderColor: '#fff',
        borderWidth: 2,
        
      },
      label: {
        show: true,
        position: 'inside',
        formatter: '{d}%',
        fontSize: 12,
        color: '#fff'
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