import { Skeleton } from '@material-ui/lab';
import React from 'react'

function PageViews({ classStyle, data, google }) {

    React.useEffect(() => {

        if (data && google.charts) {

            google.charts.load('current', {
                'packages': ['table', 'corechart', 'geochart'], callback: function () {

                    let dataChart = new google.visualization.DataTable();
                    dataChart.addColumn('string', 'mins ago');
                    dataChart.addColumn('number', 'Page Views');
                    dataChart.addColumn({ type: 'string', role: 'tooltip' });
                    dataChart.addColumn({ type: 'string', role: 'style' });
                    dataChart.addRows(data.chart_30);
                    let options = {
                        title: "",
                        width: '100%',
                        height: '230',
                        tooltip: { isHtml: true, showColorCode: false },
                        bar: { groupWidth: '100%' },
                        vAxis: { textStyle: { fontSize: '11', color: '#979797' }, minValue: 0, baselineColor: 'none', gridlines: { count: 5, color: '#e7e7e7' } },
                        backgroundColor: 'white',
                        chartArea: { left: 30, right: 0, height: 220 },
                        legend: { position: 'none' },
                        animation: {
                            duration: 2500,
                            startup: true
                        }
                    };
                    if (document.getElementById('chart_30')) {

                        if (!window.charts.chart_30) {
                            window.charts.chart_30 = new google.visualization.ColumnChart(document.getElementById('chart_30'));
                        }
                        window.charts.chart_30.draw(dataChart, options);
                    }

                }
            });
        }

    }, [data]);

    if (!data) {
        return (
            <div>
                <h3 className={classStyle.titleTop} > <Skeleton style={{ height: 16, width: '100%', marginBottom: '2px', transform: 'scale(1, 1)' }} animation="wave" /></h3>
                <div style={{ display: 'flex', alignItems: 'flex-end' }}>
                    {
                        [...Array(60)].map((j, i) => (
                            <Skeleton key={i} style={{ height: (Math.floor(Math.random() * 50) + 5) * 3, width: '1.7%', margin: '2px', transform: 'scale(1, 1)' }} animation="wave" />
                        ))
                    }
                </div>
            </div>
        );
    }

    return (
        <div>
            <h3 className={classStyle.titleTop} >Pageviews</h3>
            <div id="chart_30" style={{ marginBottom: 5 }}></div>
        </div>
    )
}

export default PageViews
