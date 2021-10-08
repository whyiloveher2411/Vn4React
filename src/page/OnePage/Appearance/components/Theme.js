import { Button, Card, CardActionArea, CardActions, CardContent, CardMedia, colors, Grid, makeStyles, Typography } from '@material-ui/core';
import { Skeleton } from '@material-ui/lab';
import RedirectWithMessage from 'components/RedirectWithMessage';
import DialogCustom from 'components/DialogCustom';
import React from 'react'
import { checkPermission } from 'utils/user';
import { useAjax } from 'utils/useAjax';
import AddCircleOutlineRoundedIcon from '@material-ui/icons/AddCircleOutlineRounded';
import AddRoundedIcon from '@material-ui/icons/AddRounded';
import FieldForm from 'components/FieldForm';
import { updateSidebar } from 'actions/sidebar';
import { useDispatch } from 'react-redux';
import { __ } from 'utils/i18n';

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
        height: 160,
    },
}));

const fieldForm = [
    {
        view: 'text',
        config: {
            title: __('Name')
        },
        name: 'name',
    },
    {
        view: 'textarea',
        config: {
            title: __('Description')
        },
        name: 'description',
    },
    {
        view: 'text',
        config: {
            title: __('Author')
        },
        name: 'author',
    },
    {
        view: 'text',
        config: {
            title: __('Author URL')
        },
        name: 'author_url',
    },
    {
        view: 'textarea',
        config: {
            title: __('Tags')
        },
        name: 'tags',
    },
    {
        view: 'image',
        config: {
            title: __('Screenshot')
        },
        name: 'screenshot',
    },
];

function Theme() {

    const classes = useStyles();

    const [data, setData] = React.useState(null);

    const permission = checkPermission('theme_management');

    const [post, setPost] = React.useState({});

    const [openCreateTheme, setOpenCreateTheme] = React.useState(false);

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
                    dispatch(updateSidebar(result.sidebar));
                }
            }
        })
    };

    const handleCloseDialog = () => {
        setOpenCreateTheme(false);
    }

    const handleCreateTheme = (e) => {
        e.preventDefault();
        ajax({
            url: 'appearance/create-theme',
            method: 'POST',
            data: post,
            success: (result) => {
                if (result.success) {
                    setData(result.rows);
                    setOpenCreateTheme(false);
                }

            }
        })
    }

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

                <Grid item md={4} sm={6} xs={12}>
                    <Card style={{ cursor: 'pointer' }} className={classes.root + ' notActive'} onClick={() => setOpenCreateTheme(true)} >
                        <CardContent style={{ height: '100%', display: 'flex', justifyContent: 'center', alignItems: 'center', flexDirection: 'column' }}>
                            <AddRoundedIcon color='primary' style={{ fontSize: '8rem', opacity: 0.7, marginTop: -32 }} />
                            <Typography gutterBottom variant="h5" component="h2">{__('Add New Theme')}</Typography>
                        </CardContent>
                    </Card>

                </Grid>


                {
                    Object.keys(data).map(theme => (
                        <Grid key={theme} item md={4} sm={6} xs={12}>
                            <Card className={classes.root + ' ' + (!data[theme].active ? 'notActive' : '')}>
                                <CardActionArea>
                                    <CardMedia
                                        className={classes.media + ' ' + (!data[theme].hasImage ? classes.noImage : '')}
                                        image={data[theme].image}
                                        title={data[theme].info.name}
                                    />
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
            <DialogCustom
                open={openCreateTheme}
                onClose={handleCloseDialog}
                title={__('Add New Theme')}
                content={
                    <Grid container spacing={3}>
                        {
                            fieldForm.map(item => (
                                <Grid item key={item.name} sm={12} xs={12}>
                                    <FieldForm
                                        compoment={item.view}
                                        config={item.config}
                                        post={post}
                                        name={item.name}
                                        onReview={(value) => { post[item.name] = value; }}
                                    />
                                </Grid>
                            ))
                        }
                    </Grid>
                }
                action={
                    <>
                        <Button onClick={handleCloseDialog}>{__('Cancel')}</Button>
                        <Button onClick={handleCreateTheme} color="primary">{__('Create')}</Button>
                    </>
                }
            />
            {Loading}
        </>
    )
}

export default Theme
