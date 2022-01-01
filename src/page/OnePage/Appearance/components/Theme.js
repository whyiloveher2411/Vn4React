import { Button, Card, CardActionArea, CardActions, CardContent, CardMedia, Grid, makeStyles, Typography } from '@material-ui/core';
import { Skeleton } from '@material-ui/lab';
import { AvatarCustom } from 'components';
import RedirectWithMessage from 'components/RedirectWithMessage';
import React from 'react';
import { useDispatch } from 'react-redux';
import { update } from 'reducers/sidebar';
import { __ } from 'utils/i18n';
import { useAjax } from 'utils/useAjax';
import { usePermission } from 'utils/user';

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
        '&:hover': {
            opacity: 1,
            transform: 'scale(1.02)',
            boxShadow: '0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22)',
        },
        '&.notActive': {
            opacity: 0.4,
            '&:hover': {
                opacity: 1,
            }
        }
    },
    noImage: {
        backgroundSize: 'contain', borderBottom: '1px solid ' + theme.palette.divider,
    },
    notActive: {
        opacity: 0.5,
        background: 'transparent',
    },
    media: {
        width: '100%',
        height: 160,
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'center',
    },
}));


function Theme() {

    const classes = useStyles();

    const permission = usePermission('theme_management').theme_management;

    const [data, setData] = React.useState(null);

    const { ajax, Loading } = useAjax();

    const dispatch = useDispatch();

    React.useEffect(() => {
        if (permission) {
            ajax({
                url: 'appearance/theme',
                method: 'POST',
                success: (result) => {
                    setData(result.rows);
                }
            })
        }
    }, []);

    const changeTheme = theme => {
        ajax({
            url: 'appearance/theme/change-theme',
            method: 'POST',
            data: {
                theme: theme
            },
            success: (result) => {
                setData(result.rows);

                if (result.sidebar) {
                    dispatch(update(result.sidebar));
                }
            }
        })
    };

    if (!permission) {
        return <RedirectWithMessage />
    }

    if (!data) {
        return (
            <Grid className={classes.grid} container spacing={4}>
                {
                    [1, 2, 3, 4, 5, 6].map(i => (
                        <Grid key={i} item md={4} sm={6} xs={12}>
                            <Card className={classes.root}>
                                <CardActionArea>
                                    <Skeleton className={classes.media} animation="wave" height={24} style={{ transform: 'scale(1, 1)', height: 160 }} />
                                    <CardContent style={{ paddingBottom: 0 }}>
                                        <Skeleton animation="wave" height={22} style={{ width: '100%', transform: 'scale(1, 1)', marginBottom: 16 }} />
                                        <Skeleton animation="wave" height={32} style={{ width: '100%', transform: 'scale(1, 1)' }} />
                                    </CardContent>
                                </CardActionArea>
                                <CardActions>
                                    <Skeleton animation="wave" height={32} style={{ width: '100%', transform: 'scale(1, 1)' }} />
                                </CardActions>
                            </Card>
                        </Grid>
                    ))
                }
            </Grid>
        );
    }
    return (
        <>
            <Grid className={classes.grid} container spacing={4}>
                {
                    Object.keys(data).map(theme => (
                        <Grid key={theme} item md={4} sm={6} xs={12}>
                            <Card className={classes.root + ' ' + (!data[theme].active ? 'notActive' : '')}>
                                <CardActionArea>
                                    {
                                        data[theme].image ?
                                            <CardMedia
                                                className={classes.media}
                                                image={data[theme].image}
                                                title={data[theme].info.name}
                                            />
                                            :
                                            <div className={classes.media}>
                                                <AvatarCustom variant='square' style={{ height: 128, width: 'auto', background: 'unset' }} />
                                            </div>
                                    }

                                    <CardContent>
                                        <Typography gutterBottom variant="h5" component="h2">{data[theme].info.name} <small style={{ fontSize: '65%' }}>(v{data[theme].info.version})</small></Typography>
                                        <Typography variant="body2" color="textSecondary" component="p">{data[theme].info.description}</Typography>
                                    </CardContent>
                                </CardActionArea>
                                <CardActions style={{ justifyContent: 'flex-end' }}>
                                    <Button variant="contained" onClick={e => changeTheme(theme)} color={data[theme].active ? 'primary' : 'default'} size="small">{data[theme].active ? __('Activated') : __('Activate')}</Button>
                                </CardActions>
                            </Card>
                        </Grid>
                    ))
                }
            </Grid>
            {Loading}
        </>
    )
}

export default Theme
