import React from 'react'
import { Typography } from '@material-ui/core'
import { makeStyles } from '@material-ui/core/styles';

const useStyles = makeStyles((theme) => ({
    root: {
        '& .present': {
            fontSize: 12,
            '& svg': {
                width: 10,
                height: 9
            }
        },
        '& .acquisition_item': {
            display: 'inline',
            fontSize: 12,
            color: 'rgba(0,0,0,0.54)',
            margin: '20px 15px 0 0'
        },
        '& .acquisition_item span': {
            display: 'inline-block',
            width: '6px',
            height: '6px',
            borderRadius: '50%',
            marginBottom: 1,
            marginRight: 2
        },
        '& #char_acquisition svg>g>g>g>rect[fill="#3367d6"]': {
            stroke: '#3367d6',
            strokeWidth: '2px',
        },
        '& #char_acquisition svg>g>g>g>rect[fill="#4285f4"]': {
            stroke: '#4285f4',
            strokeWidth: '2px',
        },
        '& #char_acquisition svg>g>g>g>rect[fill="#72a4f7"]': {
            stroke: '#72a4f7',
            strokeWidth: '2px',
        },
        '& #char_acquisition svg>g>g>g>rect[fill="#d0e0fc"]': {
            stroke: '#d0e0fc',
            strokeWidth: '2px',
        },
        '& #char_acquisition svg>g>g>g>rect[fill="#a0c2f9"]': {
            stroke: '#a0c2f9',
            strokeWidth: '2px',
        }
    },
    tabs: {
        display: 'flex',
        position: 'relative',
        height: 100,
        '&>.indicator': {
            backgroundColor: '#3f51b5',
            position: 'absolute',
            right: 0,
            width: 100,
            height: 4,
            transition: 'all 300ms cubic-bezier(0.4, 0, 0.2, 1) 0ms',
        },
    },
    tab: {
        padding: '24px 24px 16px 24px',
        cursor: 'pointer',
        '& h3': {
            fontSize: 20,
            fontWeight: 100
        },
        '&.active h4': {
            fontWeight: 500
        }
    }
}));

function General({ google, dataGA2 }) {

    const classes = useStyles();

    const [tabCurrent, setTabCurrent] = React.useState(0);

    const activeTab = React.useRef(null);
    const indicatorRef = React.useRef(null);

    React.useEffect(() => {

        if (dataGA2) {
            indicatorRef.current.style.left = activeTab.current.offsetLeft + 'px';
            indicatorRef.current.style.width = activeTab.current.offsetWidth + 'px';
            renderTabUser(tabs[tabCurrent]);
        }

        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [tabCurrent, dataGA2]);

    const renderTabUser = (tabThis) => {
        google.charts.load('current', {
            'packages': ['corechart', 'geochart'], callback: function () {
                let dataForMe = tabThis.data();

                let data = google.visualization.arrayToDataTable(dataForMe.data);
                let chart = new google.visualization.ColumnChart(document.getElementById(tabThis.id));

                let options = {
                    title: "",
                    colors: ['#3367d6', '#4285f4', '#72a4f7', '#a0c2f9', '#d0e0fc'],
                    width: '100%',
                    height: '310',
                    isStacked: true,
                    focusTarget: 'category',
                    tooltip: { isHtml: true, showColorCode: false },
                    bar: { groupWidth: '93%' },
                    chartArea: { left: 1, right: -1, height: 250 },
                    hAxis: { gridlines: { color: 'transparent' } },
                    vAxis: { textPosition: 'none', minValue: 0, baselineColor: 'none', gridlines: { count: 0, color: 'transparent' } },
                    legend: { position: 'none' },
                };

                let element = document.getElementById('char_acquisition_legend');
                if (element) {

                    let str = '';

                    for (let i = 0; i < dataForMe.options.legend.length; i++) {
                        str += '<div class="acquisition_item"><span style="background:' + dataForMe.options.colors[i] + '"></span> ' + dataForMe.options.legend[i] + '</div>'
                    };

                    element.innerHTML = str;
                }

                chart.draw(data, options);
            }
        });
    };

    const tabs = [
        {
            title: 'Traffic Channel',
            id: 'char_audience22',
            data: () => {
                let data = [
                    [{ type: 'date', label: 'Genre' }, 'Organic Search', 'Direct', 'Paid Search', 'Referral', 'Other']
                ];
                Object.keys(dataGA2.traffic_channel).forEach(function (key) {
                    data.push(
                        [
                            { v: new Date(dataGA2.traffic_channel[key].dayv), f: dataGA2.traffic_channel[key].dayf },
                            dataGA2.traffic_channel[key].channel['Organic Search'],
                            dataGA2.traffic_channel[key].channel['Direct'],
                            dataGA2.traffic_channel[key].channel['Paid Search'],
                            dataGA2.traffic_channel[key].channel['Referral'],
                            dataGA2.traffic_channel[key].channel['(Other)']
                        ]
                    );
                });
                return {
                    options: {
                        legend: ['Organic Search', 'Direct', 'Paid Search', 'Referral', 'Other'],
                        colors: ['#3367d6', '#4285f4', '#72a4f7', '#a0c2f9', '#d0e0fc'],
                    },
                    data: data
                };
            }
        },
        {
            title: 'Source / Medium',
            id: 'char_session222',
            data: () => {

                let dataTotal = [
                    [{ type: 'date', label: 'Genre' }]
                ];

                let optionsLegend = [];

                Object.keys(dataGA2.traffic_sourcemedium.key).forEach(function (key) {
                    optionsLegend.push(key);
                    dataTotal[0].push(key);
                });

                Object.keys(dataGA2.traffic_channel).forEach(function (key) {

                    var data = [{ v: new Date(dataGA2.traffic_channel[key].dayv), f: dataGA2.traffic_channel[key].dayf }];

                    for (var i = 0; i < optionsLegend.length; i++) {
                        if (dataGA2.traffic_sourcemedium.data[key] && dataGA2.traffic_sourcemedium.data[key][optionsLegend[i]]) {
                            data.push(dataGA2.traffic_sourcemedium.data[key][optionsLegend[i]]);
                        } else {
                            data.push(null);
                        }
                    };

                    dataTotal.push(data);
                });

                return {
                    options: {
                        legend: optionsLegend,
                        colors: ['#3367d6', '#4285f4', '#72a4f7', '#a0c2f9', '#d0e0fc'],
                    },
                    data: dataTotal,
                };
            }
        },
        {
            title: 'Referrals',
            id: 'char_audience322',
            data: () => {

                let dataTotal = [
                    [{ type: 'date', label: 'Genre' }]
                ];
                let optionsLegend = [];


                Object.keys(dataGA2.traffic_referrer.key).forEach(function (key) {
                    optionsLegend.push(key);
                    dataTotal[0].push(key);
                });

                Object.keys(dataGA2.traffic_channel).forEach(function (key) {

                    var data = [{ v: new Date(dataGA2.traffic_channel[key].dayv), f: dataGA2.traffic_channel[key].dayf }];

                    for (var i = 0; i < optionsLegend.length; i++) {
                        if (dataGA2.traffic_referrer.data[key] && dataGA2.traffic_referrer.data[key][optionsLegend[i]]) {
                            data.push(dataGA2.traffic_referrer.data[key][optionsLegend[i]]);
                        } else {
                            data.push(0);
                        }
                    };

                    dataTotal.push(data);
                });


                return {
                    options: {
                        legend: optionsLegend,
                        colors: ['#3367d6', '#4285f4', '#72a4f7', '#a0c2f9', '#d0e0fc'],
                    },
                    data: dataTotal
                };
            }
        },
    ];

    return (
        <div className={classes.root}>
            <div className={classes.tabs}>
                <span className='indicator' ref={indicatorRef}></span>
                {
                    tabs.map((item, i) => (
                        <div onClick={() => setTabCurrent(i)} key={item.id} ref={tabCurrent === i ? activeTab : null} className={classes.tab + ' ' + (tabCurrent === i ? 'active' : '')}>
                            <Typography component="h4" gutterBottom variant="body1">{item.title}</Typography>
                        </div>
                    ))
                }

            </div>
            <div id="char_acquisition" style={{ padding: 24 }}>
                {tabCurrent === 0 && <div style={{ height: '310px' }} id={tabs[tabCurrent].id}></div>}
                {tabCurrent === 1 && <div style={{ height: '310px' }} id={tabs[tabCurrent].id}></div>}
                {tabCurrent === 2 && <div style={{ height: '310px' }} id={tabs[tabCurrent].id}></div>}
                <div style={{ marginTop: 16 }} id="char_acquisition_legend"></div>
            </div>
        </div >
    )
}

export default General
