import Chart from "chart.js/auto";

// 複数のチャート作成を防止
let yearlyChartInstance = null;
const yearlyChart = document.getElementById("yearly-chart");
const config = {
    type: "bar",
    data: {
        labels: labels,
        datasets: [
            {
                label: "資産",
                data: assetsDataArray,
                backgroundColor: "#22C55E",
                borderSkipped: false,
                barPercentage: 0.5,
                order: 2,
                datalabels: {
                    display: false,
                },
            },
            {
                label: "負債",
                data: debutDataArray,
                backgroundColor: "#F87171",
                borderSkipped: false,
                barPercentage: 0.5,
                order: 3,
                datalabels: {
                    display: false,
                },
            },
            {
                type: "line",
                label: "資産合計",
                data: yearlyDataArray,
                backgroundColor: "#FBBF24",
                borderWidth: 1,
                borderColor: "#FBBF24",
                pointStyle: "rect",
                pointRadius: 5,
                pointHoverRadius: 7,
                pointBackgroundColor: "#FBBF24",
                order: 1,
                datalabels: {
                    display: false,
                },
            },
        ],
    },
    options: {
        animation: false,
        normalized: true,
        maintainAspectRatio: false,
        scales: {
            x: {
                title: {
                    display: true,
                    text: "年月",
                    font: 14,
                },
                grid: {
                    display: true,
                    drawOnChartArea: false,
                    drawTicks: true,
                    tickColor: "#000",
                },
                border: {
                    display: true,
                    color: "#000",
                    width: 0.5,
                },
            },
            y: {
                title: {
                    display: true,
                    text: "金額（千円）",
                    font: 14,
                },
                grid: {
                    color: function (context) {
                        if (context.tick.label === "0") {
                            return "#000";
                        } else {
                            return "#D3D3D3";
                        }
                    },
                    lineWidth: 0.5,
                    tickColor: "#000",
                },
                border: {
                    display: true,
                    color: "#000",
                    width: 0.5,
                },
                ticks: {
                    callback: function (val, index) {
                        if (val != 0) {
                            val = Math.floor(val / 1000);
                        }
                        return index % 2 === 0
                            ? this.getLabelForValue(val)
                            : "";
                    },
                },
            },
        },
        plugins: {
            legend: {
                position: "top",
                labels: {
                    font: 10,
                    boxWidth: 10,
                    boxHeight: 10,
                    borderRadius: 1,
                },
            },
            tooltip: {
                enabled: true,
                usePointStyle: true,
                callbacks: {
                    labelPointStyle: function (context) {
                        return {
                            pointStyle: "rect",
                        };
                    },
                    title: function (context) {
                        const data = context[0].dataset.label;
                        return data;
                    },
                    label: function (context) {
                        let label = "";
                        if (context) {
                            const amount = new Intl.NumberFormat("ja-JP", {
                                style: "currency",
                                currency: "JPY",
                            }).format(context.raw);
                            label = ["金額：" + amount];
                        }
                        return label;
                    },
                },
            },
        },
    },
};

function yearlyBarChart() {
    // 既存のチャートを破棄
    // if (yearlyChartInstance) {
    //     yearlyChartInstance.destroy();
    // }

    yearlyChartInstance = new Chart(yearlyChart, config);
    darkMode();
}

function darkMode() {
    if (!yearlyChartInstance) return;
    const x = yearlyChartInstance.config.options.scales.x;
    const y = yearlyChartInstance.config.options.scales.y;
    const legendLabel = yearlyChartInstance.config.options.plugins.legend.labels;
    // ローカルストレージにダークがあれば
    if (localStorage.getItem("color-theme") === "dark") {
        x.border.color = "#fff";
        x.grid.tickColor = "#fff";
        x.ticks.color = "#fff";
        x.title.color = "#fff";
        y.border.color = "#fff";
        y.grid.tickColor = "#fff";
        y.ticks.color = "#fff";
        y.title.color = "#fff";
        y.grid.color = "#fff";
        legendLabel.color = "#fff";
    } else {
        x.border.color = "#000";
        x.grid.tickColor = "#000";
        x.ticks.color = "#666";
        x.title.color = "#666";
        y.border.color = "#000";
        y.grid.tickColor = "#000";
        y.ticks.color = "#666";
        y.title.color = "#666";
        y.grid.color = "#666";
        legendLabel.color = "#666";
    }
    // チャートを更新
    yearlyChartInstance.update();
}

const themeToggleBtn = document.getElementById("theme-toggle");
const themeToggleBtnSP = document.getElementById("theme-toggle-sp");

window.addEventListener("DOMContentLoaded", () => {
    // 画面読み込み時に新しくチャートを呼び出す
    yearlyBarChart();

    // ダークモード切替ボタンクリックイベント
    // SP, PCで分けている
    if (themeToggleBtnSP) {
        themeToggleBtnSP.addEventListener("click", darkMode);
    }

    if (themeToggleBtn) {
        themeToggleBtn.addEventListener("click", darkMode);
    }
});
