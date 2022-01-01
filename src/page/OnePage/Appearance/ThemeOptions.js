import { Box, Card, CardActions, CardContent, Divider, Typography } from '@material-ui/core';
import { makeStyles } from '@material-ui/core/styles';
import { Button, CircularCustom } from 'components';
import { PageHeaderSticky } from 'components/Page';
import RedirectWithMessage from 'components/RedirectWithMessage';
import React from 'react';
import { Redirect, useHistory, useRouteMatch } from 'react-router-dom';
import { getUrlParams } from 'utils/herlperUrl';
import { __ } from 'utils/i18n';
import { useAjax } from 'utils/useAjax';
import { usePermission } from 'utils/user';
import TabContent from './components/ThemeOptions/TabContent';

const useStyles = makeStyles((theme) => ({
    card: {
        marginTop: theme.spacing(3),
    },
    root: {
        flexGrow: 1,
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

export default function ThemeOptions() {

    const classes = useStyles();

    const [tabCurrent, setTableCurrent] = React.useState(0);
    const [data, setData] = React.useState(null);
    const permission = usePermission('theme_options_management').theme_options_management;

    const history = useHistory();
    const match = useRouteMatch();

    const { subtab1 } = match.params;

    const handleChangeTab = (i) => {
        // console.log(Object.keys(data)[i]);
        history.push(Object.keys(data)[i]);
        setTableCurrent(i);
    };

    const [dataPost] = React.useState({});

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
            data: {
                options: dataPost
            },
            isGetData: false,
            success: () => {

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

    if (!subtab1 || !data[subtab1]) {
        return <Redirect to={'/appearance/theme-options/' + Object.keys(data)[0]} />;
        // return <Redirect to="/errors/error-404" />;
    }

    return (
        <PageHeaderSticky
            title={__('Theme Options')}
            header={
                <>
                    <Typography component="h2" gutterBottom variant="overline">
                        {__('Appearance')}
                    </Typography>
                    <Box display="flex" justifyContent="space-between">
                        <Typography component="h1" variant="h3">
                            {__('Theme Options')}
                        </Typography>
                        <Button
                            type="submit"
                            onClick={handleSubmitForm}
                            color="success"
                            variant="contained">
                            {__('Save Changes')}
                        </Button>
                    </Box>
                </>
            }
        >

            <div className={classes.root}>
                <div className={classes.tabs}>
                    <span className='indicator' style={{ top: tabCurrent * 48 }}></span>
                    {
                        Object.keys(data).map((g, i) => (
                            <Button key={g} onClick={e => handleChangeTab(i)} name={i} className={tabCurrent === i ? 'active' : ''} color="default">{data[g].title}</Button>
                        ))
                    }
                </div>
                <div style={{ paddingLeft: 24, width: '100%' }}>
                    <Card>
                        <CardContent>
                            <TabContent onReview={(v) => dataPost[Object.keys(data)[tabCurrent]] = v} data={data[Object.keys(data)[tabCurrent]]} />
                        </CardContent>
                    </Card>
                </div>
            </div>
            {/* <CardActions style={{ justifyContent: 'flex-end' }}>
                <Button
                    type="submit"
                    onClick={handleSubmitForm}
                    color="success"
                    variant="contained">
                    {__('Save Changes')}
                </Button>
            </CardActions> */}
            {Loading}
        </PageHeaderSticky >
    );
}