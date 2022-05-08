<template>
  <div>
    <DoughnutChart v-bind="doughnutChartProps" />
  </div>
</template>

<script lang='ts'>
import { computed, defineComponent, ref, toRef} from "vue";
import { DoughnutChart, useDoughnutChart } from "vue-chart-3";
import { Chart, ChartData, ChartOptions, registerables } from "chart.js";

Chart.register(...registerables);
export default defineComponent({
  name: "App",
  components: { DoughnutChart },
  props: {
    values:[],
    labels:[],
    colors:[],
  },
  setup(props) {
     const dataValues = ref(toRef(props, "values"));
    const dataLabels = ref(toRef(props, "labels"));
    const dataColors = ref(toRef(props, "colors"));
      const toggleLegend = ref(true);

    const testData = computed<ChartData<"doughnut">>(() => ({
      labels: dataLabels.value,
      datasets: [
        {
          data: dataValues.value,
          backgroundColor: dataColors.value,
        },
      ],
    }));

    const options = computed<ChartOptions<"doughnut">>(() => ({
      plugins: {
        legend: {
          position: toggleLegend.value ? "top" : "bottom",
        },
      },
    }));

    const { doughnutChartProps, doughnutChartRef } = useDoughnutChart({
      chartData: testData,
      options,
    });

    let index = ref(20);

    function shuffleData() {
      dataValues.value.push(index.value);
      dataLabels.value.push("Other" + index.value);
      console.log(dataValues.value);
      console.log(doughnutChartRef.value.chartInstance);
      index.value++;
    }

    function switchLegend() {
      toggleLegend.value = !toggleLegend.value;
    }

    return {
      shuffleData,
      switchLegend,
      testData,
      options,
      doughnutChartRef,
      doughnutChartProps,
    };
  },
});
</script>
