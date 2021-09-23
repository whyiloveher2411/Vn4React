import React from 'react';
import { useSelector } from 'react-redux';

function UserReturn({ google, dataGA }) {
    const theme = useSelector(state => state.theme);

    React.useEffect(() => {

        if (dataGA && google.charts) {
            google.charts.load('current', {
                'packages': ['corechart', 'geochart'], callback: function () {

                    let color = ['rgb(66, 133, 244)', 'rgb(219, 68, 55)'];
                    let dataChar = [['Type', 'Users', { role: 'style' }]];

                    dataGA.general.userVisitor.rows.forEach((item, i) => {
                        dataChar.push([item[0], item[1] * 1, color[i]]);
                    });

                    let data = google.visualization.arrayToDataTable(dataChar);
                    let options = {
                        title: "",
                        backgroundColor: 'transparent',
                        width: '100%',
                        height: '310',
                        isStacked: true,
                        focusTarget: 'category',
                        tooltip: { isHtml: true, showColorCode: false },
                        bar: { groupWidth: '60%' },
                        chartArea: { left: 30, right: -1, height: 250 },
                        vAxis: { textPosition: 'out', format: 'short', textStyle: { fontName: 'arial', fontSize: 12 }, minValue: 0, baselineColor: 'none', gridlines: { count: 2, color: 'transparent' } },
                        hAxis: { textStyle: { color: theme.palette.text.secondary } }
                    };

                    let chart = new google.visualization.ColumnChart(document.getElementById('chart_userVisitor'));
                    chart.draw(data, options);
                }
            });
        }
    }, [dataGA]);


    return (
        <div>
            <div style={{ color: theme.palette.text.secondary }}>New Users vs. Returning Users</div>
            <div id="chart_userVisitor">

            </div>
        </div>
    )
}

export default UserReturn
