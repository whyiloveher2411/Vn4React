import React from 'react'
import { Button, Typography } from '@material-ui/core'
import { makeStyles } from '@material-ui/core/styles';
import ArrowForwardIosIcon from '@material-ui/icons/ArrowForwardIos';
import { Link } from 'react-router-dom';
import { useAjax } from 'utils/useAjax';

const useStyles = makeStyles((theme) => ({
    root: {

        '& #chart_30 .google-visualization-tooltip .google-visualization-tooltip-item span': {
            fontSize: '12px !important',
            color: '#545454 !important',
        },
        '& #chart_30 .google-visualization-tooltip .google-visualization-tooltip-item:nth-child(2) span': {
            fontSize: '18px !important'
        },
        '& #chart_30 .google-visualization-tooltip .google-visualization-tooltip-item:nth-child(2)': {
            margin: '10px 0px !important'
        },
        '& table.table-chart': {
            width: '100%',
            marginTop: '20px'
        },
        '& table.table-chart td': {
            whiteSpace: 'pre'
        },
        '& table.table-chart thead td': {
            padding: '5px',
            fontSize: '12px'
        },
        '& table.table-chart.color-white thead td': {
            color: 'rgba(255,255,255,0.8)'
        },
        '& table.table-chart.color-white td': {
            color: 'white',
        },
        '& table.table-chart td': {
            padding: '5px',
            color: 'rgba(0, 0, 0, 0.87)',
            fontSize: '13px',
            height: '29px',
            borderBottom: '1px solid rgba(0,0,0,0.08)'
        },
        '& table.table-chart td:nth-child(2), table.table-chart td:nth-child(3)': {
            textAlign: 'right'
        }

    },
}));


function ActiveUserRightNow({ google, dataGA }) {

    const classes = useStyles();
    const [dataAjax, setDataAjax] = React.useState(false);
    const { ajax } = useAjax();

    React.useEffect(() => {

        setDataAjax({
            dataPageView30M: dataGA.dataPageView30M ? dataGA.dataPageView30M : {},
            realtime: dataGA.general?.realtime ? dataGA.general.realtime : {}
        });

        window.__timeIntervalActiveUserRightNow = setInterval(() => {
            ajax({
                url: 'plugin/vn4-google-analytics/dashboard/reports',
                method: 'POST',
                data: {
                    step: 'updateRealtime'
                },
                success: (result) => {
                    setDataAjax({
                        dataPageView30M: result.dataPageView30M ? result.dataPageView30M : {},
                        realtime: result.general?.realtime ? result.general.realtime : {}
                    });
                }
            });
        }, 10000);

        return () => clearInterval(window.__timeIntervalActiveUserRightNow);

    }, []);

    React.useEffect(() => {
        if (dataAjax && google.charts) {
            google.charts.load('current', {
                'packages': ['corechart', 'geochart'], callback: function () {
                    let data = new google.visualization.DataTable();

                    let data30m = [];

                    let pageView, flagHasData = false;

                    let count = 0;

                    for (count in dataAjax.dataPageView30M) {
                        break;
                    }
                    if (count > 5) {
                        count = 35;
                    } else {
                        count = count * 1 + 30;
                    }

                    for (let i = count; i >= count - 30; i--) {

                        if (dataAjax.dataPageView30M[i]) {
                            flagHasData = true;
                            pageView = dataAjax.dataPageView30M[i];
                        } else {
                            pageView = 0;
                        }

                        data30m.push([
                            `${i} mins ago`, pageView * 1, `${i} min${i === 1 ? '' : 's'} ago\n${pageView}\nPage Views`
                        ]);
                    }

                    if (flagHasData) {
                        data.addColumn('string', 'mins ago');
                        data.addColumn('number', 'Page Views');
                        data.addColumn({ type: 'string', role: 'tooltip' });
                        data.addRows(data30m);

                        let options = {
                            title: "",
                            colors: ['#8eb6f9'],
                            width: '100%',
                            height: '100',
                            tooltip: { isHtml: true, showColorCode: false },
                            bar: { groupWidth: '89%' },
                            hAxis: { title: '', textPosition: 'none', baselineColor: 'none', gridlines: { count: 0, color: 'transparent' } },
                            vAxis: { textPosition: 'none', minValue: 0, baselineColor: 'none', gridlines: { count: 0, color: 'transparent' } },
                            backgroundColor: '#4285f4',
                            chartArea: { left: 1, right: -1, height: 100 },
                            legend: { position: 'none' },
                        };

                        let chart = new google.visualization.ColumnChart(document.getElementById('chart_30'));
                        chart.draw(data, options);
                    } else {
                        if (document.getElementById('chart_30')) {
                            document.getElementById('chart_30').innerHTML = '<p style="margin: 40px 0;color:white; text-align:center;">No data to display!<p>';
                        }
                    }
                }
            });
        }
    }, [dataAjax]);

    if (!dataAjax) {
        return <></>;
    }

    return (
        <div className={classes.root}>
            <div style={{ color: '#fff', font: "400 14px/10px 'Roboto',sans-serif", letterSpacing: 0 }}>Active Users right now</div>
            <div style={{ color: '#fff', fontWeight: 400, fontSize: 50, letterSpacing: 0, marginTop: 13 }}>{dataAjax.realtime['totalsForAllResults']?.['rt:activeUsers']}</div>
            <div style={{ borderBottom: '1px solid rgba(255,255,255,0.18)', marginBottom: 16, paddingBottom: '4px', color: 'rgba(255,255,255,0.8)', font: "400 12px 'Roboto',sans-serif", letterSpacing: '-0.06px' }}>Page views per minute</div>
            <div id="chart_30">

            </div>
            <table className="table-chart color-white">
                <thead>
                    <tr>
                        <td>Top Active Pages</td>
                        <td style={{ width: 78 }}>Active Users</td>
                    </tr>
                </thead>
                <tbody>

                    {
                        dataAjax.realtime.rows ?
                            dataAjax.realtime.rows.map((item, index) => (
                                <tr key={index}>
                                    <td>
                                        {
                                            item[0].length > 31 ?
                                                (item[0].substring(0, 10) + '...' + item[0].substring(item[0].length - 14, item[0].length))
                                                : item[0]
                                        }
                                    </td>
                                    <td>{item[1]}</td>
                                </tr>
                            )) :
                            <tr>
                                <td colSpan="2"><Typography align="center" variant="h6" style={{ color: 'white', margin: '16px 0' }}>No data to display!</Typography></td>
                            </tr>
                    }

                </tbody>
            </table>

            <div style={{ textAlign: 'right', marginTop: 8 }}>
                <Button component={Link} to="/plugin/vn4-google-analytics/realtime" style={{ color: 'white', fontWeight: '400', fontSize: 13 }} endIcon={<ArrowForwardIosIcon style={{ marginLeft: 5 }} size="small" />}>Real-Time Report</Button>
            </div>

        </div>
    );
}

export default ActiveUserRightNow
