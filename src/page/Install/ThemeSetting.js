import { Button, Card, CardActionArea, CardActions, CardContent, CardMedia, Checkbox, colors, FormControlLabel, Grid, makeStyles, Typography } from '@material-ui/core';
import { Skeleton } from '@material-ui/lab';
import React from 'react'
import { useAjax } from 'utils/useAjax';


const useStyles = makeStyles(() => ({
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
            background: 'white',
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
    notActive: {
        opacity: 0.5,
        background: 'transparent',
    },
    media: {
        height: 160,
    },
}));


function ThemeSetting({ data, setThemeActive, themeActive }) {

    const classes = useStyles();

    const {ajax} = useAjax();

    const handelImportData = (e) => {
        setThemeActive({
            ...themeActive,
            importData: e.target.checked,
        })
    }
    const changeTheme = theme => {

        if (theme !== themeActive.name) {
            setThemeActive({
                name: theme,
                importData: false,
            })
        }else{
            setThemeActive({
                name: '',
                importData: false,
            })
        }
        // ajax({
        //     url: 'appearance/theme/change-theme',
        //     method: 'POST',
        //     data: {
        //         theme: theme
        //     },
        //     success: (result) => {
        //         // setData(result.rows);
        //     }
        // })
    };
    if (!data) {
        return (
            <Grid className={classes.grid} container spacing={4}>
                {
                    [1, 2, 3, 4, 5, 6].map(i => (
                        <Grid key={i} item md={6} sm={6} xs={12}>
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
        <Grid className={classes.grid} container spacing={4}>
            {
                Object.keys(data).map(theme => (
                    <Grid key={theme} item md={6} sm={6} xs={12}>
                        <Card className={classes.root}>
                            <CardActionArea>
                                <CardMedia
                                    className={classes.media}
                                    image={process.env.REACT_APP_BASE_URL + 'themes/' + theme + '.png'}
                                    style={data[theme].hasImage ? { borderBottom: '1px solid #eee' } : { backgroundSize: 'contain', borderBottom: '1px solid #eee' }}
                                    title="Contemplative Reptile"
                                />
                                <CardContent>
                                    <Typography gutterBottom variant="h5" component="h2">{data[theme].name} <small style={{ fontSize: '65%' }}>(v{data[theme].version})</small></Typography>
                                    <Typography variant="body2" color="textSecondary" component="p">{data[theme].description}</Typography>
                                </CardContent>
                            </CardActionArea>
                            <CardActions style={{ justifyContent: 'space-between' }}>
                                <FormControlLabel style={{ opacity: themeActive.name === theme ? 1 : 0 }} control={<Checkbox onChange={handelImportData} checked={themeActive.name === theme && themeActive.importData} name="importdata" />} label="Import Data example" />
                                <Button variant="contained" onClick={e => changeTheme(theme)} color={themeActive.name === theme ? 'primary' : 'default'} size="small">{themeActive.name === theme ? 'Activated' : 'Activate'}</Button>
                            </CardActions>
                        </Card>
                    </Grid>
                ))
            }
        </Grid>
    )
}

export default ThemeSetting
