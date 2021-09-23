import { Button, Card, CardActions, CardContent, colors, Divider, Grid, makeStyles, Typography } from '@material-ui/core';
import { Skeleton } from '@material-ui/lab';
import React from 'react'
import { useDispatch } from 'react-redux';
import { Page, PluginHook } from 'components';
import { useAjax } from 'utils/useAjax';
import { updatePlugins } from 'actions/plugins';
import { updateSidebar } from 'actions/sidebar';
import { checkPermission } from 'utils/user';
import RedirectWithMessage from 'components/RedirectWithMessage';

const useStyles = makeStyles((theme) => ({
    grid: {
        marginTop: 16
    },
    root: {
        width: '100%',
        height: '100%',
        display: 'flex',
        flexDirection: 'column',
        justifyContent: 'space-between',
        transition: 'all .15s ease-in',
        cursor: 'pointer',
        '&:hover': {
            opacity: 1,
            transform: 'scale(1.02)',
            boxShadow: '0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22)',
            '& $byVersion': {
                display: 'flex'
            }
        },
        '& a, & .link': {
            color: theme.palette.text.link,
            fontSize: 13,
            cursor: 'pointer',
            textAlign: 'center',
        },
        '&.notActive': {
            opacity: 0.4,
            '&:hover': {
                opacity: 1,
            }
        }
    },
    byVersion: {
        fontSize: 13,
        display: 'none',
        position: 'absolute',
        top: 8,
        width: '100%',
        justifyContent: 'space-between',
        padding: '0 16px',
        fontWeight: 500,

    },
    media: {
        height: 160,
    },
    description: {
        fontSize: 12,
        lineHeight: '16px',
        letterSpacing: 'normal',
        overflowWrap: 'normal',
        display: '-webkit-box',
        textOverflow: 'ellipsis',
        overflow: 'hidden',
        '-webkit-line-clamp': 3,
        '-webkit-box-orient': 'vertical',
        height: 48,
        maxWidth: 280,
    },
}));


function Plugins() {

    const classes = useStyles();

    const [data, setData] = React.useState(null);

    const permission = checkPermission('plugin_management');

    const { ajax, Loading } = useAjax();

    const dispatch = useDispatch();

    React.useEffect(() => {
        if (permission) {
            ajax({
                url: 'plugin/get-list',
                method: 'POST',
                success: (result) => {
                    setData(result.rows);
                }
            })
        }
    }, []);

    const changePlugin = plugin => {
        ajax({
            url: 'plugin/get-list/in-active-plugin',
            method: 'POST',
            isGetData: false,
            data: {
                plugin: plugin
            },
            success: (result) => {
                setData(result.rows);
                dispatch(updatePlugins(result.plugins));

                if (result.sidebar) {
                    dispatch(updateSidebar(result.sidebar));
                }
            }
        })
    };

    if (!permission) {
        return <RedirectWithMessage />
    }
    if (!data) {
        return (
            <Page className={classes.main} title="Plugin">
                <div>
                    <Typography component="h2" gutterBottom variant="overline">Plugin</Typography>
                    <Typography component="h1" variant="h3">Extensions that change your settings</Typography>
                </div>
                <Grid className={classes.grid} container spacing={3}>
                    {
                        [1, 2, 3, 4, 5, 6].map(i => (
                            <Grid key={i} item md={4} sm={6} xs={12}>
                                <Card >
                                    <CardContent style={{
                                        display: 'flex', flexDirection: 'column', textAlign: 'center', alignItems: 'center'
                                    }}>
                                        <Skeleton style={{ height: 128, width: '100%', transform: 'scale(1, 1)' }} animation="wave" height={24} />
                                        <Skeleton animation="wave" height={24} style={{ margin: '8px 0', width: '100%', transform: 'scale(1, 1)' }} />
                                        <Skeleton animation="wave" height={40} style={{ width: '100%', transform: 'scale(1, 1)' }} />
                                    </CardContent>
                                    <Divider />
                                    <CardActions style={{ justifyContent: 'space-between' }}>
                                        <Skeleton animation="wave" height={40} style={{ width: '100%', transform: 'scale(1, 1)' }} />
                                    </CardActions>
                                </Card>
                            </Grid>
                        ))
                    }
                </Grid>
            </Page>
        );
    }

    return (

        <Page className={classes.main} title="Appearance">
            <div>
                <Typography component="h2" gutterBottom variant="overline">Plugin</Typography>
                <Typography component="h1" variant="h3">Extensions that change your settings</Typography>
            </div>

            <Grid className={classes.grid} container spacing={3}>
                {
                    Object.keys(data).map(plugin => (
                        <Grid key={plugin} item md={4} sm={6} xs={12}>
                            <Card className={classes.root + ' ' + (!data[plugin].active ? 'notActive' : '')}>
                                <CardContent style={{
                                    display: 'flex', flexDirection: 'column', textAlign: 'center', alignItems: 'center'
                                }}>
                                    <div className={classes.byVersion}><small>By <a href={data[plugin].info.author_url} target="_blank">{data[plugin].info.author}</a></small><small>(v{data[plugin].info.version})</small></div>
                                    <div><img style={{ height: 128, width: 'auto', marginBottom: 8 }} src={data[plugin].image} /></div>
                                    <Typography gutterBottom variant="h5" component="h2">{data[plugin].info.name}</Typography>
                                    <Typography className={classes.description} variant="body2" color="textSecondary" component="p">{data[plugin].info.description}</Typography>
                                </CardContent>
                                <Divider />
                                <CardActions style={{ justifyContent: 'space-between' }}>
                                    <div style={{ display: 'flex', alignItems: 'center' }}>
                                        <a href={data[plugin].document} target="_blank">Read Docs</a>
                                        {
                                            data[plugin].active &&
                                            <PluginHook plugin={plugin} hook='Custom/LinkSetting' />
                                        }
                                    </div>
                                    <Button variant="contained" onClick={e => changePlugin(plugin)} size="small" color={data[plugin].active ? 'primary' : 'default'}>{data[plugin].active ? 'Activated' : 'Activate'}</Button>
                                </CardActions>
                            </Card>
                        </Grid>
                    ))
                }
            </Grid>
            {Loading}
        </Page>
    )
}

export default Plugins
