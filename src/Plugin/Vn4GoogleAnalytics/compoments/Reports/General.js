import { Typography } from '@material-ui/core';
import { makeStyles } from '@material-ui/core/styles';
import React from 'react';
import { useSelector } from 'react-redux';

const useStyles = makeStyles((theme) => ({
    root: {
        '& .present': {
            fontSize: 12,
            '& svg': {
                width: 10,
                height: 9
            }
        },
        '& svg>g>g>g:nth-child(1) rect': {
            fill: theme.palette.divider + ' !important',
        },
        '& .uninverse .increase, & .inverse .decrease': {
            color: '#0f9d58 !important',
            '& svg': {
                fill: '#0f9d58 !important',
            }
        },
        '& .uninverse .decrease, , & .inverse .increase': {
            color: '#db4437 !important',
            '& svg': {
                fill: '#db4437 !important',
            }
        }
    },
    tabs: {
        display: 'flex',
        position: 'relative',
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

const IconIncrease = () => {

    return (
        <span className={'present increase'}>
            <svg id="metric-table-increase-delta-arrow_cache67" viewBox="0 0 7 9" xmlns="http://www.w3.org/2000/svg" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
                <g transform="translate(-2, -3)">
                    <polygon points="5.65 3 2.5 6.26454545 4.8625 6.26454545 4.8625 12 6.4375 12 6.4375 6.26454545 8.8 6.26454545"></polygon>
                </g>
            </svg>
        </span>
    )
}

const IconDecrease = () => {
    return (
        <span className={'present decrease'}>
            <svg id="metric-table-decrease-delta-arrow_cache64" viewBox="0 0 7 9" xmlns="http://www.w3.org/2000/svg" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
                <g transform="translate(3, 4.5)">
                    <polygon transform="rotate(-180)" points="0 -4.5 -3.15 -1.2354545 -0.7875 -1.2354545 -0.7875 4.5 0.7875 4.5 0.7875 -1.2354545 3.15 -1.2354545"></polygon>
                </g>
            </svg>
        </span>
    )
}


function General({ google, dataGA }) {

    const classes = useStyles();
    const theme = useSelector(state => state.theme);

    const [tabCurrent, setTabCurrent] = React.useState(0);

    const activeTab = React.useRef(null);
    const indicatorRef = React.useRef(null);

    React.useEffect(() => {

        indicatorRef.current.style.left = activeTab.current.offsetLeft + 'px';
        indicatorRef.current.style.width = activeTab.current.offsetWidth + 'px';

        tabs[tabCurrent].func(tabs[tabCurrent]);

    }, [tabCurrent]);

    const renderTabUser = (tabThis) => {
        google.charts.load('current', {

            'packages': ['corechart', 'geochart'], callback: function () {
                let dataUsers = tabThis.data.data.map((item) => {
                    item[0].v = new Date(item[0].v);
                    item[1] = item[1] * 1;
                    item[3] = item[3] * 1;
                    return item;
                });

                let data = new google.visualization.DataTable();
                data.addColumn('date', 'Date');
                data.addColumn('number', '');
                data.addColumn({ type: 'string', role: 'tooltip' });
                data.addColumn('number', tabThis.data.title);
                data.addColumn({ type: 'string', role: 'tooltip', p: { html: true } });
                data.addRows(dataUsers);
                let options = {
                    title: '',
                    backgroundColor: 'transparent',
                    colors: ['rgb(66, 133, 244)', 'rgb(101, 152, 239)'],
                    chartArea: { left: 0, right: 4 },
                    tooltip: { isHtml: true, showColorCode: false },
                    pointSize: 4,
                    lineWidth: 2,
                    height: 300,
                    series: {
                        1: { lineDashStyle: [4, 2] },
                    },
                    crosshair: { orientation: 'vertical', trigger: 'focus', color: '#f1f1f1' },
                    focusTarget: 'category',
                    pointsVisible: false,
                    hAxis: { title: '', format: 'MMM d', textStyle: { color: theme.palette.text.secondary, fontSize: 12 }, baselineColor: 'none', gridlines: { count: 4, color: 'transparent' } },
                    vAxis: { textPosition: 'in', format: 'short', textStyle: { color: theme.palette.text.secondary, fontWeight: 100, fontName: 'arial', fontSize: 12 }, minValue: 0, baselineColor: 'none', gridlines: { count: 3, color: theme.palette.divider } },
                };
                let chart = new google.visualization.LineChart(document.getElementById(tabThis.id));
                chart.draw(data, options);

            }
        });
    };


    const tabs = [
        {
            id: 'char_audience',
            data: dataGA.dataAudience['ga:users'],
            func: renderTabUser,
            iconType: 1,
        },
        {
            id: 'char_session',
            data: dataGA.dataAudience['ga:sessions'],
            func: renderTabUser,
            iconType: 1,
        },
        {
            id: 'char_audience3',
            data: dataGA.dataAudience['ga:bounceRate'],
            func: renderTabUser,
            iconType: 0,
        },
        {
            id: 'char_audience4',
            data: dataGA.dataAudience['ga:avgSessionDuration'],
            func: renderTabUser,
            iconType: 1,
        }
    ];

    return (
        <div className={classes.root}>
            <div className={classes.tabs}>
                <span className='indicator' ref={indicatorRef}></span>
                {
                    tabs.map((item, i) => (
                        <div onClick={() => setTabCurrent(i)} key={item.id} ref={tabCurrent === i ? activeTab : null} className={classes.tab + ' ' + (tabCurrent === i ? 'active' : '')}>
                            <Typography component="h4" gutterBottom variant="body1">{item.data.title}</Typography>
                            <Typography component="h3" gutterBottom variant="body1">{item.data.total}</Typography>
                            <Typography className={item.iconType === 1 ? 'uninverse' : 'inverse'} component="h6" gutterBottom variant="body1">
                                <span className={item.data.present > 0 ? 'increase' : 'decrease'}>
                                    {item.data.present > 0 ? <IconIncrease /> : <IconDecrease />} {Math.abs(item.data.present).toFixed(1)}%
                                </span>
                            </Typography>
                        </div>
                    ))
                }

            </div>
            <div style={{ padding: 24 }}>
                {tabCurrent === 0 && <div className={tabs[tabCurrent].iconType === 1 ? 'uninverse' : 'inverse'} id={tabs[tabCurrent].id}></div>}
                {tabCurrent === 1 && <div className={tabs[tabCurrent].iconType === 1 ? 'uninverse' : 'inverse'} id={tabs[tabCurrent].id}></div>}
                {tabCurrent === 2 && <div className={tabs[tabCurrent].iconType === 1 ? 'uninverse' : 'inverse'} id={tabs[tabCurrent].id}></div>}
                {tabCurrent === 3 && <div className={tabs[tabCurrent].iconType === 1 ? 'uninverse' : 'inverse'} id={tabs[tabCurrent].id}></div>}
            </div>
        </div >
    )
}

export default General
