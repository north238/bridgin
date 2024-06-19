import Chart from "chart.js/auto";
import ChartDataLabels from "chartjs-plugin-datalabels";
Chart.register(ChartDataLabels);

(async function () {
    new Chart(document.getElementById("monthly-chart"), {
        type: "doughnut",
        data: {
            datasets: [
                {
                    label: "カテゴリ（小分類）",
                    data: categoryArrays,
                    backgroundColor: categoryColorArrays,
                    datalabels: {
                        color: function (context) {
                            var value = context.dataset.data[context.dataIndex];
                            return value.amount < 15000
                                ? context.dataset.backgroundColor
                                : "white";
                        },
                        anchor: function (context) {
                            var value = context.dataset.data[context.dataIndex];
                            return value.amount < 15000 ? "end" : "center";
                        },
                        align: function (context) {
                            var value = context.dataset.data[context.dataIndex];
                            return value.amount < 15000 ? "end" : "center";
                        },
                        offset: -9,
                        display: true,
                    },
                },
                {
                    type: "pie",
                    label: "ジャンル（大分類）",
                    data: genreArrays,
                    backgroundColor: genreColorArrays,
                    radius: "165%",
                    datalabels: {
                        align: "end",
                        offset: -5
                    }
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
                        return ratio > 5;
                    },
                    color: "white",
                    font: {
                        weight: "bold",
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
                            const footer =
                                "資産比率：" + roundedPercentage + "%";
                            return footer;
                        },
                    },
                },
            },
        },
    });
})();
