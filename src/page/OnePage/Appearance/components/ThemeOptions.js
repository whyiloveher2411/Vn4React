import { Card, CardActions, CardContent, colors, Divider } from '@material-ui/core';
import { makeStyles } from '@material-ui/core/styles';
import { CircularCustom, Button } from 'components';
import RedirectWithMessage from 'components/RedirectWithMessage';
import React from 'react';
import { getUrlParams } from 'utils/herlperUrl';
import { useAjax } from 'utils/useAjax';
import { checkPermission } from 'utils/user';
import TabContent from './ThemeOptions/TabContent';

const useStyles = makeStyles((theme) => ({
    card: {
        marginTop: theme.spacing(3),
    },
    root: {
        flexGrow: 1,
        backgroundColor: theme.palette.background.paper,
        display: 'flex',
        minHeight: 224,
    },
    tabs: {
        display: 'flex',
        flexDirection: 'column',
        borderRight: `1px solid ${theme.palette.divider}`,
        position: 'relative',
        '&>.indicator': {
            backgroundColor: '#3f51b5',
            position: 'absolute',
            right: 0,
            width: 2,
            height: 48,
            transition: 'all 300ms cubic-bezier(0.4, 0, 0.2, 1) 0ms',
        },
        '&>button': {
            width: '100%', minWidth: 160, minHeight: 48, opacity: 0.7,
            '&.active': {
                opacity: 1
            }
        },
        '& .MuiButton-label': {
            justifyContent: 'left',
            textAlign: 'left'
        }
    },

}));

export default function ThemeOptions({ history }) {

    const classes = useStyles();

    const [tabCurrent, setTableCurrent] = React.useState(0);
    const [data, setData] = React.useState(null);
    const permission = checkPermission('theme_options_management');

    const handleChangeTab = (i) => {
        history.push('?tab=' + Object.keys(data)[i]);
        setTableCurrent(i);
    };

    const [dataPost, setDataPost] = React.useState({});

    const { ajax, Loading } = useAjax();

    React.useEffect(() => {

        if (permission) {
            ajax({
                url: 'appearance/theme-options',
                method: 'POST',
                success: (result) => {
                    let tab = getUrlParams(window.location.search, 'tab');

                    if (result.rows) {
                        setData(result.rows);
                    }

                    if (tab && result.rows && result.rows[tab]) {
                        setTableCurrent(Object.keys(result.rows).indexOf(tab));
                    }
                }
            })
        }

    }, []);

    const handleSubmitForm = () => {
        ajax({
            url: 'appearance/theme-options/post',
            method: 'POST',
            data: dataPost,
            isGetData: false,
            success: (result) => {

            },
        })
    };

    if (!permission) {
        return <RedirectWithMessage />
    }

    if (!data) {
        return (
            <div style={{ position: 'relative', minHeight: 350 }}>
                <CircularCustom />
            </div>
        );
    }

    return (
        <Card className={classes.card}>
            <CardContent style={{ padding: 0 }}>
                <div className={classes.root}>
                    <div className={classes.tabs}>
                        <span className='indicator' style={{ top: tabCurrent * 48 }}></span>
                        {
                            Object.keys(data).map((g, i) => (
                                <Button key={g} onClick={e => handleChangeTab(i)} name={i} className={tabCurrent === i ? 'active' : ''} color="default">{data[g].title}</Button>
                            ))
                        }
                    </div>
                    <div style={{ padding: 24, width: '100%' }}>
                        <TabContent onReview={(v) => dataPost[Object.keys(data)[tabCurrent]] = v} data={data[Object.keys(data)[tabCurrent]]} />
                    </div>
                </div>
            </CardContent>
            <Divider />
            <CardActions style={{ justifyContent: 'flex-end' }}>
                <Button
                    type="submit"
                    onClick={handleSubmitForm}
                    color="success"
                    variant="contained">
                    Save Changes
                </Button>
            </CardActions>
            {Loading}
        </Card>
    );
}