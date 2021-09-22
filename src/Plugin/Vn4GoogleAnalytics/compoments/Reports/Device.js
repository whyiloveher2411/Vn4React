import React from 'react'
import SmartphoneIcon from '@material-ui/icons/Smartphone';
import DesktopMacIcon from '@material-ui/icons/DesktopMac';
import TabletIcon from '@material-ui/icons/Tablet';
import { Button, Typography } from '@material-ui/core';
import { Link } from 'react-router-dom';
import ArrowForwardIosIcon from '@material-ui/icons/ArrowForwardIos';

function Device({ google, dataGA2, showLinkReport }) {

    React.useEffect(() => {
        if (dataGA2 && google.charts) {
            google.charts.load('current', {

                'packages': ['corechart', 'geochart'], callback: function () {

                    let d = [
                        ['Device', 'Sessions'],
                        ['mobile', dataGA2.sessions_by_device?.mobile[1] || 1],
                        ['desktop', dataGA2.sessions_by_device?.desktop[1] || 1],
                        ['tablet', (dataGA2.sessions_by_device?.tablet && dataGA2.sessions_by_device.tablet[1]) || 1],
                    ];

                    if (dataGA2.sessions_by_device) {
                        Object.keys(dataGA2.sessions_by_device).forEach(function (key) {

                            if (document.getElementById(key)) {
                                document.getElementById(key).innerHTML = dataGA2.sessions_by_device[key][2] + '%';
                            }

                            let element = document.getElementById(key + '_precent');

                            if (element) {
                                if (dataGA2.sessions_by_device[key][3] > 0) {
                                    element.outerHTML = '<svg style="height: 9px;width: 11px;display: inline;" fill="#0f9d58" id="metric-table-increase-delta-arrow_cache65" viewBox="0 0 7 9" xmlns="http://www.w3.org/2000/svg" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false"><g transform="translate(-2, -3)"><polygon points="5.65 3 2.5 6.26454545 4.8625 6.26454545 4.8625 12 6.4375 12 6.4375 6.26454545 8.8 6.26454545"></polygon></g></svg><div style="display: inline;color: #0f9d58;font-size: 12px;"> ' + dataGA2.sessions_by_device[key][3] + '%</div>';
                                } else if (dataGA2.sessions_by_device[key][3] < 0) {
                                    element.outerHTML = '<svg style="height: 9px;width: 11px;display: inline;" fill="#db4437" id="metric-table-decrease-delta-arrow_cache64" viewBox="0 0 7 9" xmlns="http://www.w3.org/2000/svg" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false"><g transform="translate(3, 4.5)"><polygon transform="rotate(-180)" points="0 -4.5 -3.15 -1.2354545 -0.7875 -1.2354545 -0.7875 4.5 0.7875 4.5 0.7875 -1.2354545 3.15 -1.2354545"></polygon></g></svg><div style="display: inline;color: #db4437;font-size: 12px;"> ' + (-dataGA2.sessions_by_device[key][3]) + '%</div>';
                                }
                            }
                        });
                    }

                    let data = google.visualization.arrayToDataTable(d);

                    let options = {
                        title: '',
                        backgroundColor: 'transparent',
                        colors: ['#4285f4', '#45a5f5', '#93d5ed'],
                        pieHole: 0.7,
                        pieSliceBorderColor: 'transparent',
                        pieSliceText: "none",
                        chartArea: { width: 300, height: 200 },
                        legend: 'none',
                    };

                    let chart = new google.visualization.PieChart(document.getElementById('chart_sessions_by_device'));
                    chart.draw(data, options);
                }
            });
        }
    }, [dataGA2]);

    return (
        <div style={{ position: 'relative', height: '100%', paddingBottom: showLinkReport ? 48 : 0 }}>
            <Typography variant="body2" style={{ fontSize: 16 }}>Sessions by device</Typography>
            <div id="chart_sessions_by_device" style={{ display: 'inline-block', height: '250px', width: '100%' }}></div>
            <div style={{ marginTop: '20px', display: 'flex' }}>
                <div style={{ display: 'inline-block', width: '33%', textAlign: 'center' }}>
                    <SmartphoneIcon style={{ color: '#4285f4' }} />
                    <Typography variant="body2">Mobile</Typography>
                    <Typography variant="subtitle1" id="mobile">--</Typography>
                    <div id="mobile_precent">

                    </div>
                </div>


                <div style={{ display: 'inline-block', width: '33%', textAlign: 'center' }}>
                    <DesktopMacIcon style={{ color: '#45a5f5' }} />
                    <Typography variant="body2">Desktop</Typography>
                    <Typography variant="subtitle1" id="desktop">--</Typography>
                    <div id="desktop_precent">

                    </div>
                </div>


                <div style={{ display: 'inline-block', width: '33%', textAlign: 'center' }}>
                    <TabletIcon style={{ color: '#93d5ed' }} />
                    <Typography variant="body2">Tablet</Typography>
                    <Typography variant="subtitle1" id="tablet">--</Typography>
                    <div id="tablet_precent">

                    </div>
                </div>
            </div>
            {
                showLinkReport &&
                <div style={{ position: 'absolute', bottom: 0, right: 0 }}>
                    <Link to="/plugin/vn4-google-analytics/reports">
                        <Button style={{ fontWeight: '400', fontSize: 13 }} endIcon={<ArrowForwardIosIcon style={{ marginLeft: 5 }} size="small" />}>Overview Report</Button>
                    </Link>
                </div>
            }

        </div>
    )
}

export default Device
