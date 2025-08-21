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

window.addEventListener('resize', function () {
  barChart.resize();
});




