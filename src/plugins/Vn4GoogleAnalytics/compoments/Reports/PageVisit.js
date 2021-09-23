import { makeStyles } from '@material-ui/core/styles';
import React from 'react';
import { useSelector } from 'react-redux';

const useStyles = makeStyles((theme) => ({
    root: {
        '& table.table-chart': {
            width: '100%',
            marginTop: '20px'
        },
        '& table.table-chart thead td': {
            padding: 5,
            fontSize: 12,
        },
        '& table.table-chart.color-white thead td': {
            color: 'rgba(255,255,255,0.8)',
        },
        '& table.table-chart.color-white td': {
            color: 'white',
        },
        '& table.table-chart td': {
            whiteSpace: 'pre',
            padding: 5,
            fontSize: 13,
            height: 29,
            borderBottom: '1px solid ' + theme.palette.divider,
            color: theme.palette.text.secondary
        },
        '& table.table-chart td:nth-child(2), table.table-chart td:nth-child(3)': {
            textAlign: 'right'
        }
    },
}));


function PageVisit({ dataGA2 }) {
    const classes = useStyles();
    const theme = useSelector(state => state.theme);

    React.useEffect(() => {
        if (dataGA2) {
            let str = '<thead><tr style="padding: 12px 5px;"><td style="color:' + theme.palette.text.secondary + ';font-size:14px;">Page</td><td style="width: 77px;color:' + theme.palette.text.secondary + ';font-size:14px;">Pageviews</td><td style="width: 83px;color:' + theme.palette.text.secondary + ';font-size:14px;">Page Value</td></tr></thead><tbody></tbody>';

            if (dataGA2.path_pageview) {
                for (var i = 0; i < dataGA2.path_pageview.length; i++) {
                    str += '<tr><td><div style="max-width:250px;white-space: pre;word-break: break-all;width: 100%;display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 1;overflow: hidden;height: 17px;">' + dataGA2.path_pageview[i][0] + '</div></td><td>' + dataGA2.path_pageview[i][1] + '</td><td>$' + dataGA2.path_pageview[i][2] + '</td></tr>';
                };
            }
            document.getElementById('path_pageview').innerHTML = str;
        }
    }, [dataGA2]);

    return (
        <div className={classes.root}>
            <table className="table-chart" id="path_pageview" style={{ margin: 0 }}>

            </table>
        </div >
    )
}

export default PageVisit
