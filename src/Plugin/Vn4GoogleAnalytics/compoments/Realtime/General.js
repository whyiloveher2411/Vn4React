import React from 'react'
import { makeStyles } from '@material-ui/core'
import { Skeleton } from '@material-ui/lab';

const useStyles = makeStyles((theme) => ({
    root: {
        textAlign: 'center',
        '& .device_item': {
            color: '#fff',
            display: 'inline-block',
            fontWeight: 'bold',
            float: 'left',
            height: 21,
            fontSize: 11,
            textShadow: '#7f7f7f 0 -1px',
            lineHeight: '21px',
            '-webkit-box-reflect': 'below 1px -webkit-gradient(linear,left top,left bottom,from(transparent),color-stop(0.5,rgba(255,255,255,0)),to(rgba(255,255,255,.3)))'
        }

    },
}));

function General({ data, classStyle }) {

    const classes = useStyles();


    React.useEffect(() => {

        if (data) {

            document.getElementById('rt_user_label').innerHTML = data.rt_user.label;
            document.getElementById('rt_user_value').innerHTML = data.rt_user.value;

            document.getElementById('rt_trafficType_label').innerHTML = data.rt_trafficType.label;
            document.getElementById('rt_trafficType_value').innerHTML = data.rt_trafficType.value;

        }
    }, [data]);

    if (!data) {
        return (
            <div className={classes.root}>
                <div style={{ display: 'flex', justifyContent: 'center' }}>
                    <Skeleton style={{ height: 38, width: 200, marginTop: '20px', marginBottom: '8px', transform: 'scale(1, 1)' }} animation="wave" />
                </div>
                <div style={{ display: 'flex', justifyContent: 'center' }}>
                    <Skeleton style={{ height: 84, width: 100, transform: 'scale(1, 1)' }} animation="wave" />
                </div>
                <span className="counting right_now" data-count style={{ fontSize: '75px' }} id="total_">{data.total}</span>
                <div style={{ display: 'flex', justifyContent: 'center' }}>
                    <Skeleton style={{ height: 14, width: 100, marginTop: '6px', transform: 'scale(1, 1)' }} animation="wave" />
                </div>
                <div className="processing" style={{ paddingTop: '25px' }}>
                    <Skeleton style={{ height: 40, width: '100%', transform: 'scale(1, 1)' }} animation="wave" />
                    <Skeleton style={{ height: 40, width: '100%', transform: 'scale(1, 1)', marginTop: 16 }} animation="wave" />
                    <Skeleton style={{ height: 14, width: '100%', marginTop: '10px', transform: 'scale(1, 1)' }} animation="wave" />
                </div>
            </div>
        )
    }

    return (
        <div className={classes.root}>
            <div style={{ fontSize: '200%', paddingTop: '20px' }}>Right now</div>
            <span className="counting right_now" data-count style={{ fontSize: '75px' }} id="total_">{data.total}</span>
            <div style={{ fontSize: '82%' }}>active users on site</div>
            <div className="processing" style={{ paddingTop: '25px' }}>

                <div id="rt_user_label" style={{ textAlign: 'left', marginBottom: '3px', display: 'flex' }} />
                <div id="rt_user_value" style={{ height: '21px', borderRadius: '4px', display: 'flex' }} />
                <br />
                <div id="rt_trafficType_label" style={{ textAlign: 'left', marginBottom: '3px', display: 'flex' }} />
                <div id="rt_trafficType_value" style={{ height: '21px', borderRadius: '4px', display: 'flex' }} />
                <br />
                <small style={{ fontSize: '12px' }}>* Data updates continuously and each pageview</small>
            </div>
        </div>
    )
}

export default General
