import { Box, Button, Divider, Grid, makeStyles } from '@material-ui/core';
import Card from '@material-ui/core/Card';
import CardActions from '@material-ui/core/CardActions';
import CardContent from '@material-ui/core/CardContent';
import Typography from '@material-ui/core/Typography';
import React from 'react';
import { Link } from 'react-router-dom';
import ButtonEvent from './ButtonEvent';

const useStyles = makeStyles((theme) => ({
    img: {
        maxWidth: '100%',
        width: '100%',
        maxHeight: 200,
        [theme.breakpoints.down('sm')]: {
            maxHeight: 400,
        },
    },
}));


function SettingBlock1({ title, description, image, actions, children }) {

    const classes = useStyles();

    return (
        <Box display="flex" width={1} justifyContent="center" style={{ marginBottom: 32 }}>
            <Card style={{ width: 1000, maxWidth: '100%' }}>
                <CardContent>
                    <Grid container spacing={3}>
                        <Grid item sm={12} md={7}>
                            <Typography variant="h3" style={{ fontWeight: 'normal' }}>{title}</Typography>
                            <Typography style={{ paddingTop: 16, letterSpacing: 0.2 }} variant="body1">{description}</Typography>
                        </Grid>
                        <Grid item sm={12} md={5}>
                            <Box display="flex" height={1} width={1} justifyContent="center" alignItems="center">
                                <img className={classes.img} src={image} />
                            </Box>
                        </Grid>
                        {
                            children ?
                                <Grid item sm={12} md={12}>
                                    {children}
                                </Grid>
                                : null
                        }
                    </Grid>
                </CardContent>
                <Divider />
                <CardActions>
                    {
                        Boolean(actions) &&
                        actions.map((button, index2) => {

                            if (button.event) {
                                return <ButtonEvent key={index2} {...button} />
                            }

                            return <Button key={index2} component={Link} to={button.link} size="small" color={button.color ?? 'primary'}>
                                {button.label}
                            </Button>
                        })
                    }
                </CardActions>
            </Card>
        </Box>
    )
}

export default SettingBlock1
