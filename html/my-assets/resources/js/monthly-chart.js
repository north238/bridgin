import Chart from "chart.js/auto";
import ChartDataLabels from "chartjs-plugin-datalabels";
Chart.register(ChartDataLabels);

let monthlyChartInstance = null;
const monthlyChart = document.getElementById("monthly-chart");
const config = {
    type: "doughnut",
    data: {
        datasets: [
            {
                label: "カテゴリ（小分類）",
                data: categoryArrays,
                borderColor: "#F5F5F5",
                backgroundColor: categoryColorArrays,
                datalabels: {
                    color: function (context) {
                        var value = context.dataset.data[context.dataIndex];
                        return value.amount < 16000
                            ? context.dataset.backgroundColor
                            : "white";
                    },
                    anchor: function (context) {
                        var value = context.dataset.data[context.dataIndex];
                        return value.amount < 16000 ? "end" : "center";
                    },
                    align: function (context) {
                        var value = context.dataset.data[context.dataIndex];
                        return value.amount < 16000 ? "end" : "center";
                    },
                    offset: -6,
                    display: "auto",
                },
            },
            {
                type: "pie",
                label: "ジャンル（大分類）",
                data: genreArrays,
                borderColor: "#F5F5F5",
                backgroundColor: genreColorArrays,
                radius: "165%",
                datalabels: {
                    align: "center",
                    textAlign: "center",
                    formatter: function (value, context) {
                        const val = context.dataset.data[context.dataIndex];
                        const data = context.dataset.data;
                        const totalAmount = data.reduce(
                            (sum, item) => sum + item.amount,
                            0
                        );
                        const name = val.name;
                        const amount = val.amount;
                        const ratio = (amount / totalAmount) * 100;
                        const formatRatio = parseFloat(ratio.toFixed(0)) + "%";
                        const formatRatioAndName = [name, formatRatio];
                        return formatRatioAndName;
                    },
                },
            },
        ],
    },
    plugins: [ChartDataLabels],
    options: {
        maintainAspectRatio: false,
        normalized: true,
        parsing: {
            key: "amount",
        },
        animation: {
            duration: 0,
        },
        plugins: {
            datalabels: {
                formatter: function (value, context) {
                    const val = context.dataset.data[context.dataIndex];
                    const data = context.dataset.data;
                    const totalAmount = data.reduce(
                        (sum, item) => sum + item.amount,
                        0
                    );
                    const amount = val.amount;
                    const ratio = (amount / totalAmount) * 100;
                    const formatRatio = parseFloat(ratio.toFixed(0)) + "%";
                    return formatRatio;
                },
                display: function (context) {
                    const value = context.dataset.data[context.dataIndex];
                    const data = context.dataset.data;
                    const totalAmount = data.reduce(
                        (sum, item) => sum + item.amount,
                        0
                    );
                    const amount = value.amount;
                    const ratio = (amount / totalAmount) * 100;
                    return ratio > 8;
                },
                color: "white",
                font: {
                    size: 14,
                },
            },
            tooltip: {
                enabled: true,
                usePointStyle: true,
                callbacks: {
                    labelPointStyle: function () {
                        return {
                            pointStyle: "pie",
                        };
                    },
                    title: function (context) {
                        const data = context[0].dataset.label;
                        return data;
                    },
                    label: function (context) {
                        let label = "";
                        const data = context.raw;
                        if (data) {
                            const name = data.name;
                            const amount = new Intl.NumberFormat("ja-JP", {
                                style: "currency",
                                currency: "JPY",
                            }).format(data.amount);
                            label = ["資産名：" + name, "金額：" + amount];
                        }
                        return label;
                    },
                    footer: function (context) {
                        const data = context[0].dataset.data;
                        const parsed = context[0].parsed;
                        const totalAmount = data.reduce(
                            (sum, item) => sum + item.amount,
                            0
                        );
                        const percentage = (parsed / totalAmount) * 100;
                        const roundedPercentage = parseFloat(
                            percentage.toFixed(0)
                        );
                        const footer = "資産比率：" + roundedPercentage + "%";
                        return footer;
                    },
                },
            },
        },
    },
};

function monthlyPieChart() {
    if (monthlyChartInstance) {
        monthlyChartInstance.destroy();
    }

    monthlyChartInstance = new Chart(monthlyChart, config);
}

window.addEventListener("DOMContentLoaded", monthlyPieChart);
