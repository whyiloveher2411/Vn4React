import React from 'react'
import { makeStyles } from '@material-ui/core'

const useStyles = makeStyles((theme) => ({
    root: {
        '& .item-h': {
            borderRadius: '5px',
            padding: '10px'
        },
        '& .item-h:hover': {
            cursor: 'pointer',
            background: '#f1f3f4',
        }
    },
}));


function UserTime({ google, dataGA2 }) {

    const classes = useStyles();

    React.useEffect(() => {

        if (dataGA2 && google.charts) {
            google.charts.load('current', {
                'packages': ['corechart', 'geochart'], callback: function () {

                    Object.keys(dataGA2.data_active_total_user).forEach(function (key) {
                        if (document.getElementById(key)) {
                            document.getElementById(key).innerText = dataGA2.data_active_total_user[key];
                        }
                    });

                    let d = [
                        [{ type: 'date', label: 'Date' }, { type: 'number', label: 'Daily' }, { type: 'number', label: 'Weekly' }, { type: 'number', label: 'Monthly' }]
                    ];

                    for (let i = 0; i < dataGA2.data_active_user.length; i++) {
                        d.push([{ v: new Date(dataGA2.data_active_user[i][0].v), f: dataGA2.data_active_user[i][0].f }, dataGA2.data_active_user[i][1], dataGA2.data_active_user[i][2], dataGA2.data_active_user[i][3]]);
                    };

                    let data = google.visualization.arrayToDataTable(d);

                    let options = {
                        title: '',
                        colors: ['#93d5ed', '#45a5f5', '#4285f4'],
                        chartArea: { left: 30, right: 15 },
                        tooltip: { showColorCode: true },
                        pointSize: 6,
                        lineWidth: 2,
                        pointsVisible: false,
                        height: 300,
                        focusTarget: 'category',
                        series: {
                            0: {
                                areaOpacity: 0
                            }
                        },
                        crosshair: { orientation: 'vertical', trigger: 'focus', color: '#f1f1f1' },
                        hAxis: { title: '', format: 'MMM dd, yyyy', gridlines: { count: 3, color: 'transparent' } },
                        vAxis: { textPosition: 'out', format: 'short', gridlines: { count: 3, color: '#f1f1f1' } },
                    };

                    let chart = new google.visualization.LineChart(document.getElementById('chart_active_user'));
                    chart.draw(data, options);
                }
            });
        }
    }, [dataGA2]);
    return (
        <div className={classes.root}>
            <dir style={{ color: 'rgba(0,0,0,0.54)' }}>Active Users</dir>
            <div style={{ display: 'flex', alignItems: 'center' }}>
                <div id="chart_active_user" style={{ display: 'inline-block', height: '280px', width: '100%' }}>

                </div>
                <div style={{ width: '88px', textAlign: 'center' }}>
                    <div class="item-h">
                        <div style={{ color: 'rgba(0,0,0,0.54)', fontSize: '12px', letterSpacing: 0, alignItems: 'center', marginBottom: '12px' }}><span style={{ display: 'inline-block', width: 6, height: 6, background: '#4285f4', borderRadius: '50%', whiteSpace: 'white-space' }}></span>  &nbsp;30 Days</div>
                        <div style={{ color: 'rgba(0,0,0,0.87)', fontSize: 16, letterSpacing: 0 }} id="number30day">--</div>
                    </div>

                    <div class="item-h" style={{ margin: '10px 0' }}>
                        <div style={{ color: 'rgba(0,0,0,0.54)', fontSize: '12px', letterSpacing: 0, alignItems: 'center', marginBottom: '12px' }}><span style={{ display: 'inline-block', width: 6, height: 6, background: '#45a5f5', borderRadius: '50%', whiteSpace: 'white-space' }}></span>  &nbsp;7 Days</div>
                        <div style={{ color: 'rgba(0,0,0,0.87)', fontSize: 16, letterSpacing: 0 }} id="number7day">--</div>
                    </div>

                    <div class="item-h">
                        <div style={{ color: 'rgba(0,0,0,0.54)', fontSize: '12px', letterSpacing: 0, alignItems: 'center', marginBottom: '12px' }}><span style={{ display: 'inline-block', width: 6, height: 6, background: '#93d5ed', borderRadius: '50%', whiteSpace: 'white-space' }}></span>  &nbsp;1 Day</div>
                        <div style={{ color: 'rgba(0,0,0,0.87)', fontSize: 16, letterSpacing: 0 }} id="number1day">--</div>
                    </div>
                </div>
            </div>
        </div>
    )
}

export default UserTime
