import { colors, Grid, makeStyles, Paper, Typography } from '@material-ui/core';
import React from 'react';
import { useAjax } from 'utils/useAjax';
import FieldForm from 'components/FieldForm';
import { Skeleton } from '@material-ui/lab';
import { NotFound, Button } from 'components';
import { __ } from 'utils/i18n';

const useStyles = makeStyles((theme) => ({
    root: {
        flexGrow: 1,
        marginTop: theme.spacing(3),
    },
    divider: {
        backgroundColor: colors.grey[300],
    },
    tabs: {
        position: 'sticky',
        top: 0,
        backgroundColor: '#f4f6f8',
        zIndex: 2
    },
    tabsItem: {
        whiteSpace: 'nowrap',
    },
    paper: {
        padding: 16,
        marginBottom: 24
    },
    textOverflow: {
        overflow: 'hidden',
        width: '100%',
        display: '-webkit-box',
        '-webkit-line-clamp': 2,
        '-webkit-box-orient': 'vertical'
    }
}));


function SidebarItem({ classes, sidebar, widgets }) {
    console.log(sidebar);
    return <Paper className={classes.paper} >
        <Typography variant="h5">{sidebar.title}</Typography>
        <Typography variant="body2">{sidebar.description}</Typography>

        {
            (() => {

                let templates = JSON.parse(JSON.stringify(widgets));

                if (sidebar.fieldsDefault) {

                    let fieldsDefault = {};

                    Object.keys(sidebar.fieldsDefault).forEach(key => {
                        fieldsDefault['_' + key] = sidebar.fieldsDefault[key];
                    });

                    Object.keys(templates).forEach(key => {
                        templates[key].items = { ...fieldsDefault, ...templates[key].items };
                    });
                }

                return (
                    <FieldForm
                        compoment='flexible'
                        config={
                            {
                                title: '',
                                templates: templates
                            }
                        }
                        post={sidebar}
                        name='post'
                        onReview={(value, key2) => { sidebar.post = value }}
                    />
                )
            })()
        }

    </Paper>

}

function Widget() {

    const classes = useStyles();

    const { ajax, Loading } = useAjax();

    const [widgets, setWidgets] = React.useState({});
    const [sidebars, setSidebars] = React.useState(false);

    React.useEffect(() => {

        ajax({
            url: 'widget/get',
            method: 'POST',
            success: (result) => {

                if (result.widgets) {
                    Object.keys(result.widgets).forEach(key => {
                        result.widgets[key].items = result.widgets[key].fields;
                    });

                    setWidgets(result.widgets);
                }

                if (result.sidebars) {

                    Object.keys(result.sidebars).forEach(key => {

                        if (result.sidebars[key].post) {

                            result.sidebars[key].post.forEach((item, index) => {
                                console.log(result.sidebars[key].post[index], { ...item, ...item.data });
                                result.sidebars[key].post[index] = { ...item, ...item.data };

                            });

                        }

                    });

                    setSidebars(result.sidebars);
                }

            }
        })

    }, []);

    const handleSubmit = () => {

        ajax({
            url: 'widget/post',
            method: 'POST',
            isGetData: false,
            data: {
                sidebars: sidebars
            },
            success: (result) => {
                console.log(result);
            }
        })

    }

    if (sidebars === false) {
        return (
            <>
                <br />
                <Grid container spacing={3}>
                    <Grid item xs={12} md={6}>
                        {
                            [0, 1].map((key) => (
                                <Paper key={key} className={classes.paper} >
                                    <Skeleton style={{ height: 20, transform: 'scale(1, 1)' }} animation="wave" />
                                    <Skeleton style={{ height: 18, marginTop: 5, transform: 'scale(1, 1)' }} animation="wave" />
                                    <Skeleton style={{ height: 48, marginTop: 16, transform: 'scale(1, 1)' }} animation="wave" />
                                    <Skeleton style={{ height: 48, marginTop: 10, transform: 'scale(1, 1)' }} animation="wave" />
                                    <Skeleton style={{ height: 36, marginTop: 10, transform: 'scale(1, 1)' }} animation="wave" />
                                </Paper>
                            ))
                        }
                    </Grid>
                    <Grid item xs={12} md={6}>
                        {
                            [0, 1].map((key) => (
                                <Paper key={key} className={classes.paper} >
                                    <Skeleton style={{ height: 20, transform: 'scale(1, 1)' }} animation="wave" />
                                    <Skeleton style={{ height: 18, marginTop: 5, transform: 'scale(1, 1)' }} animation="wave" />
                                    <Skeleton style={{ height: 48, marginTop: 16, transform: 'scale(1, 1)' }} animation="wave" />
                                    <Skeleton style={{ height: 48, marginTop: 10, transform: 'scale(1, 1)' }} animation="wave" />
                                    <Skeleton style={{ height: 36, marginTop: 10, transform: 'scale(1, 1)' }} animation="wave" />
                                </Paper>
                            ))
                        }
                    </Grid>

                </Grid>
            </>
        );
    }

    let ObjectSidebars = Object.keys(sidebars);

    if (ObjectSidebars.length) {
        return (
            <>
                <br />
                <Grid container spacing={3}>
                    <Grid item xs={12} md={6}>
                        {
                            ObjectSidebars.map((key, i) => (
                                i % 2 === 0 ?
                                    <SidebarItem
                                        key={key}
                                        classes={classes}
                                        sidebar={sidebars[key]}
                                        widgets={widgets}
                                    />
                                    : <React.Fragment key={i}></React.Fragment>
                            ))
                        }
                    </Grid>
                    <Grid item xs={12} md={6}>
                        {
                            ObjectSidebars.map((key, i) => (
                                i % 2 === 1 ?
                                    <SidebarItem
                                        key={key}
                                        classes={classes}
                                        sidebar={sidebars[key]}
                                        widgets={widgets}
                                    />
                                    : <React.Fragment key={i}></React.Fragment>
                            ))
                        }
                    </Grid>

                </Grid>
                <Button
                    onClick={handleSubmit}
                    type="submit"
                    color="success"
                    variant="contained">
                    {__('Save Changes')}
                </Button>
                {Loading}
            </>
        )
    }

    return <>
        <br />
        <NotFound />
    </>
}

export default Widget
