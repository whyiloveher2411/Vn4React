import { Box, Button, CardMedia, Collapse, IconButton, makeStyles, Typography } from '@material-ui/core';
import HelpOutlineIcon from '@material-ui/icons/HelpOutline';
import { CustomTooltip, FieldForm, MaterialIcon } from 'components';
import React from 'react';
import { useAjax } from 'utils/useAjax';

const useStyles = makeStyles((theme) => ({
    root: {
        '& .custom_scroll::-webkit-scrollbar-track': {
            background: '#b3b3b3'
        }
    },
    thumbnail: {
        height: 74,
        backgroundSize: 'contain',
        marginBottom: 8,
    },
    widgets: {
        borderTop: '1px solid rgb(51, 51, 51)',
        borderLeft: '1px solid rgb(51, 51, 51)',
        background: 'rgb(60 60 60)'
    },
    screen: {
        width: '100%', flexShrink: 0,
        transition: 'transform .3s ease',
        WebkitTransition: 'transform .3s ease',
        OTransition: 'transform .3s ease',
        transition: 'transform .3s ease',
        marginRight: theme.spacing(3),
    },
    widgetItem: {
        padding: theme.spacing(2),
        borderLeft: '1px solid rgb(51, 51, 51)',
        borderBottom: '1px solid rgb(51, 51, 51)',
        cursor: 'pointer',
        position: 'relative',
        '&:last-child': {
            borderRight: '1px solid rgb(51, 51, 51)',
        },
        '&:nth-child(3n)': {
            borderRight: '1px solid rgb(51, 51, 51)',
        },
        '&:nth-child(3n + 1), &:first-child': {
            borderLeft: 'none',
        },
        '&:hover': {
            backgroundColor: 'rgba(0,0,0,.08)'
        },
        '& .icon': {
            opacity: 0,
            cursor: 'pointer',
            position: 'absolute',
            right: 5,
            top: 3,
            width: 16,
            color: 'rgb(166, 166, 166)',
        },
        '&:hover .icon': {
            opacity: .7,
        },
        '&:hover .icon:hover': {
            opacity: 1,
        }

    },
    expandWidgets: {
        cursor: 'pointer',
        height: '32px',
        background: 'rgb(43, 43, 43)',
    },
    textWhite: {
        color: 'rgb(217, 217, 217) !important',
    },
    widgetTitle: {
        color: 'rgb(166, 166, 166)',
    },
    groupArrow: {
        transition: 'transform .3s ease',
        WebkitTransition: 'transform .3s ease',
        OTransition: 'transform .3s ease',
        transition: 'transform .3s ease',
        color: 'rgb(166, 166, 166)',
    },
    widgetGroup: {
        background: '#404040'
    }
}))


function EditWidget({ post, widgets, onSubmit, editWiget = false }) {

    const ajax = useAjax();

    const classes = useStyles();

    const [render, setRender] = React.useState(0);

    const [widget, setWidget] = React.useState(post ? post.__widget_type : null);

    const [editForm, setEditForm] = React.useState(editWiget);

    const [tabIndex, setTabIndex] = React.useState(false);

    const [widgetsState, setWidgetsState] = React.useState(widgets.data);

    const handleChooseWidget = (value) => {
        if (widgetsState[value]) {
            setWidget(value);
            post.__widget_type = value;
            post.__title = widgetsState[value].title;
        }
        setEditForm(true);
    };

    React.useEffect(() => {
        if (!widgetsState) {
            ajax.ajax({
                url: 'widget/get-widget',
                method: 'POST',
                success: (result) => {

                    if (result.widgets) {
                        widgets.set(result.widgets);
                        setWidgetsState(result.widgets);
                    }
                }
            })
        }
    }, []);


    const [sections, setSections] = React.useState([
        {
            title: 'Layout',
            key: 'layout',
            show: false,
        },
        {
            title: 'Elements',
            key: 'element',
            show: false,
        },
        {
            title: 'Media',
            key: 'media',
            show: false,
        },
        {
            title: 'Prebuilt Layouts',
            key: 'prebuilt_layouts',
            show: false,
        },
        {
            title: 'Component',
            key: 'component',
            show: false,
        },
    ]);

    const handleChangeWidgetType = (index) => {

        if (index === tabIndex) {
            setTabIndex(false);
        } else {
            setTabIndex(index);

            setSections(prev => {
                prev[index].show = true;
                return prev;
            });
        }

        setTimeout(() => {
            if (sections[tabIndex]) {
                setSections(prev => {
                    prev[tabIndex].show = false;
                    return [...prev];
                });
            }

        }, 300);
    };

    const handleOnSubmit = () => {

        ajax.ajax({
            url: 'widget/get-widget-html',
            method: 'POST',
            data: {
                ...post
            },
            success: (result) => {
                if (result.html) {
                    onSubmit(result.html);
                }
            }
        });

        // onSubmit
    }

    if (widgetsState) {
        return (
            <Box className={classes.root} display="flex" style={{ overflow: 'hidden', height: '100%' }} >
                <div className={classes.screen + ' ' + classes.widgetGroup + ' custom_scroll'} style={{ height: '100%', overflowY: 'auto', transform: 'translateX(' + (editForm ? 'calc( -100% - 24px )' : 0) + ')' }}>

                    {
                        sections.map((tab, index) => (
                            <div key={index}>
                                <Box onClick={() => handleChangeWidgetType(index)} className={classes.expandWidgets} display="flex" alignItems="center">
                                    <MaterialIcon style={{ transform: 'rotate( ' + (tabIndex === index ? 90 : 0) + 'deg)' }} className={classes.groupArrow + ' ' + classes.textWhite} icon="ArrowRight" />
                                    <Typography variant="h6" className={classes.textWhite}>{tab.title}</Typography>
                                </Box>
                                <Collapse in={tabIndex === index}>
                                    {
                                        tab.show &&
                                        <Box className={classes.widgets} display="grid" gridTemplateColumns="1fr 1fr 1fr">
                                            {
                                                Object.keys(widgetsState).filter(key => widgetsState[key].type === tab.key).map(key => (
                                                    <div onClick={() => handleChooseWidget(key)} key={key} className={classes.widgetItem}>
                                                        <CardMedia
                                                            className={classes.thumbnail}
                                                            image={widgetsState[key].thumbnail}
                                                            title="Contemplative Reptile"
                                                        />
                                                        <Typography className={classes.widgetTitle} align="center" variant="body2" color="textSecondary" component="p">
                                                            {widgetsState[key].title}
                                                        </Typography>
                                                        <CustomTooltip
                                                            title={<div style={{ width: 350, maxWidth: 350 }}>
                                                                <strong>{widgetsState[key].title}</strong>
                                                                <div style={{ textAlign: 'center' }}>
                                                                    <img style={{ margin: '8px auto', maxWidth: '100%', maxHeight: 300 }} src=
                                                                        {widgetsState[key].thumbnail} />
                                                                </div>
                                                                {widgetsState[key].description}
                                                            </div>}
                                                        >
                                                            <HelpOutlineIcon className='icon' />
                                                        </CustomTooltip>
                                                    </div>
                                                ))
                                            }
                                        </Box>
                                    }
                                </Collapse>
                            </div>
                        ))
                    }
                </div>
                <Box className={classes.screen + ' custom_scroll'} style={{ height: '100%', overflowY: 'auto', padding: 24, transform: 'translateX(' + (editForm ? 'calc( -100% - 24px )' : 0) + ')' }} display="flex" flexDirection="column" gridGap={24} >

                    <Box display="flex" alignItems="center" gridGap={4}>
                        <IconButton onClick={() => setEditForm(false)} color="default" aria-label="Go Back" component="span">
                            <MaterialIcon icon="ArrowBackOutlined" />
                        </IconButton>
                        {
                            Boolean(widgetsState[widget]) &&
                            <Typography variant="h5">{widgetsState[widget].title}</Typography>
                        }
                    </Box>
                    {
                        Boolean(widget && widgetsState[widget]) &&
                        <>
                            <Box display="flex" flexDirection="column" gridGap={24} flexGrow="1">
                                <Typography variant="body2">{widgetsState[widget].description}</Typography>
                                <Typography variant="h3" >Widget Options</Typography>
                                {
                                    Object.keys(widgetsState[widget].fields).map(key => (
                                        <FieldForm
                                            key={key}
                                            compoment={widgetsState[widget].fields[key].view}
                                            config={widgetsState[widget].fields[key]}
                                            post={post}
                                            name={key}
                                            onReview={(value) => { }}
                                        />
                                    ))
                                }

                            </Box>
                            <Button
                                style={{ marginTop: 16 }}
                                color="primary"
                                type="submit"
                                onClick={handleOnSubmit}
                                variant="contained">
                                Save Changes
                            </Button>
                        </>
                    }
                </Box>
            </Box >
        )
    }
    return <div className={classes.screen + ' ' + classes.widgetGroup + ' custom_scroll'} style={{ height: '100%', overflow: 'hidden' }} ></div>
}

export default EditWidget
