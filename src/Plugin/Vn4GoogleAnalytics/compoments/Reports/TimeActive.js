import React from 'react'
import { makeStyles } from '@material-ui/core/styles';
import { Tooltip } from '@material-ui/core';
import {
    withStyles
} from "@material-ui/core/styles";
import { useSelector } from 'react-redux';

const BlueOnGreenTooltip = withStyles({
    tooltip: {
        color: "#000",
        backgroundColor: "white",
        margin: 5,
        boxShadow: '0 4px 5px 0 rgb(0 0 0 / 14%), 0 1px 10px 0 rgb(0 0 0 / 12%), 0 2px 4px -1px rgb(0 0 0 / 20%)',
        '& p': {
            margin: '10px 0',
            fontWeight: 100,
            fontSize: 12,
        }
    }
})(Tooltip);



const useStyles = makeStyles((theme) => ({
    root: {
        '& #table_chart_users_by_time td': {
            textAlign: 'center',
            height: 12,
            margin: 1,
            display: 'inline-block',
            width: '30.14px',
            color: theme.palette.text.secondary
        },
        '& #table_chart_users_by_time tr': {
            display: 'flex'
        },
        '& #table_chart_users_by_time td:not(.not-hover):hover': {
            background: '#2f5ec4!important'
        },
        '& #table_chart_users_by_time td.hour': {
            width: 37,
            textAlign: 'center'
        },
    },
}));


function TimeActive({ dataGA, dataGA2 }) {
    const classes = useStyles();
    const theme = useSelector(state => state.theme);

    const kFormatter = (num) => {
        return Math.abs(num) > 999 ? Math.sign(num) * ((Math.abs(num) / 1000).toFixed(1)) + 'k' : Math.sign(num) * Math.abs(num)
    }

    React.useEffect(() => {

        if (dataGA2) {
            let range = Math.floor((dataGA2.users_by_time.max - dataGA2.users_by_time.min) / 4);

            let space = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

            document.getElementById('range_colors').innerHTML = '<div><span style="display:inline-block;width: 55px;height:10px;background:#93d5ed;"></span> '
                + '<span style="display:inline-block;width: 55px;height:10px;background:#45a5f5;"></span> '
                + '<span style="display:inline-block;width: 55px;height:10px;background:#4285f4;"></span> '
                + '<span style="display:inline-block;width: 55px;height:10px;background:#2f5ec4;"></span> </div><div style="font-size: 11px;color: ' + theme.palette.text.secondary + ';">'
                + kFormatter(dataGA2.users_by_time.min) + space + kFormatter(dataGA2.users_by_time.min + range) + space + kFormatter(dataGA2.users_by_time.min + range * 2) + space + kFormatter(dataGA2.users_by_time.min + range * 3) + space + kFormatter(dataGA2.users_by_time.max) + '</div>';
        }
    }, [dataGA2]);

    let range2 = 10;

    const dayOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

    if (dataGA2) {
        range2 = 50 / (dataGA2.users_by_time.max - dataGA2.users_by_time.min);
    }

    return (
        <div className={classes.root}>
            <div style={{ color: theme.palette.text.secondary }}>Users by time of day</div>
            <div id="chart_users_by_time" style={{ height: 400 }}>
                <table id="table_chart_users_by_time" style={{ width: '100%', fontSize: '12px', marginTop: 15 }}>
                    {
                        Boolean(dataGA2 && dataGA2.users_by_time.data) &&
                        dataGA2.users_by_time.data.map((item, i) => (
                            <tr key={i}>
                                {
                                    (() => {

                                        let time = '';

                                        if (i === 0) {
                                            time = '12am';
                                        } else if (i < 12) {
                                            time = i + 'am';
                                        } else if (i === 12) {
                                            time = '12pm';
                                        } else {
                                            time = (i - 12) + 'pm';
                                        }

                                        return (<>
                                            {
                                                item.map((item2, i2) => {
                                                    let indexColor = Math.round((item2 - dataGA2.users_by_time.min) * range2 - 1);
                                                    if (indexColor < 0) indexColor = 0;
                                                    return (
                                                        <BlueOnGreenTooltip key={i2} title={<div><p>{`${dayOfWeek[i2]} ${time}`}</p><p style={{ fontSize: 16, fontWeight: 400 }}>{kFormatter(item2)}</p><p>Users</p></div>}   >
                                                            <td data-index={indexColor} style={{ background: dataGA.listColours[indexColor] }}>
                                                            </td>
                                                        </BlueOnGreenTooltip>
                                                    );
                                                })
                                            }
                                            <td class="hour not-hover"> {i % 2 === 0 ? time : ''}</td>
                                        </>);
                                    })()
                                }
                            </tr>
                        ))
                    }

                    <tr class="day_of_week">
                        <td class="not-hover">Sun</td>
                        <td class="not-hover">Mon</td>
                        <td class="not-hover">Tue</td>
                        <td class="not-hover">Wed</td>
                        <td class="not-hover">Thu</td>
                        <td class="not-hover">Fri</td>
                        <td class="not-hover">Sat</td>
                        <td></td>
                    </tr>
                </table>
                <div id="range_colors" style={{ marginTop: 15 }}></div>
            </div>
        </div>
    )
}

export default TimeActive
