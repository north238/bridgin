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
                        const val = context.dataset.data[context.dataIndex];
                        const data = context.dataset.data;
                        const totalAmount = data.reduce(
                            (sum, item) => sum + item.amount,
                            0
                        );
                        const amount = val.amount;
                        const ratio = (amount / totalAmount) * 100;
                        return ratio < 4
                            ? context.dataset.backgroundColor
                            : "white";
                    },
                    anchor: function (context) {
                        const val = context.dataset.data[context.dataIndex];
                        const data = context.dataset.data;
                        const totalAmount = data.reduce(
                            (sum, item) => sum + item.amount,
                            0
                        );
                        const amount = val.amount;
                        const ratio = (amount / totalAmount) * 100;
                        return ratio < 4 ? "end" : "center";
                    },
                    align: function (context) {
                        const val = context.dataset.data[context.dataIndex];
                        const data = context.dataset.data;
                        const totalAmount = data.reduce(
                            (sum, item) => sum + item.amount,
                            0
                        );
                        const amount = val.amount;
                        const ratio = (amount / totalAmount) * 100;
                        return ratio < 4 ? "end" : "center";
                    },
                    offset: -5,
                    display: function (context) {
                        const val = context.dataset.data[context.dataIndex];
                        const data = context.dataset.data;
                        const totalAmount = data.reduce(
                            (sum, item) => sum + item.amount,
                            0
                        );
                        const amount = val.amount;
                        const ratio = (amount / totalAmount) * 100;
                        return ratio < 4 ? false : "auto";
                    },
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
        responsive: true,
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
                        const dataArr = context.dataset.data;
                        if (data) {
                            const name = "資産名：" + data.name;

                            // 資産合計額を取得
                            const totalAmount = dataArr.reduce(
                                (sum, item) => sum + item.amount,
                                0
                            );
                            const percentage = (data.amount / totalAmount) * 100;
                            const roundedPercentage = parseFloat(
                                percentage.toFixed(0)
                            );
                            const ratio =
                                "資産比率：" + roundedPercentage + "%";

                            // 金額を円マークを付けて取得
                            const amount = new Intl.NumberFormat("ja-JP", {
                                style: "currency",
                                currency: "JPY",
                            }).format(data.amount);
                            const amountStr = "金額：" + amount;

                            label = [name, amountStr, ratio];
                        }
                        return label;
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
