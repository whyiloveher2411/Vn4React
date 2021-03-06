import { Button, Card, CardContent, Grid, makeStyles } from '@material-ui/core';
import { Hook } from 'components';
import FieldForm from 'components/FieldForm';
import React from 'react';

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
    chipUser: {
        marginRight: 4
    },
    tabs: {
        display: 'flex',
        flexDirection: 'column',
        borderRight: `1px solid ${theme.palette.divider}`,
        position: 'relative',
        width: 160,
        '&>.indicator': {
            backgroundColor: '#3f51b5',
            position: 'absolute',
            right: 0,
            width: 2,
            height: 48,
            transition: 'all 300ms cubic-bezier(0.4, 0, 0.2, 1) 0ms',
        },
        '&>button': {
            width: '100%', maxWidth: 160, height: 48, opacity: 0.7,
            fontSize: 15,
            textTransform: 'unset',
            fontWeight: 'normal',
            '&.active': {
                opacity: 1,
                color: theme.palette.primary.main,
            },
            '& span': {
                textOverflow: "ellipsis", overflow: "hidden", whiteSpace: 'nowrap',
            }
        },
        '& .MuiButton-label': {
            justifyContent: 'left'
        }
    },
    tabsItem: {
        padding: '6px 16px'
    }

}));


function Form(props) {

    const { data, postType, onUpdateData } = props;
    const [tabCurrent, setTableCurrent] = React.useState(
        {
            [postType]: 0
        }
    );

    const classes = useStyles();

    if (!data.post) {
        data.post = {};
    }

    const onReview = (value, key) => {
        onUpdateData((prev) => {
            if (typeof key === 'object' && key !== null) {
                prev.post = {
                    ...prev.post,
                    ...key
                };
            } else {
                prev.post[key] = value;
            }

            return prev;
        });
    };

    let listFieldInTabs = [], listFieldNotIntabs = Object.keys(data.config.fields), listTabs = [];

    if (data.config?.tabs) {

        listTabs = Object.keys(data.config.tabs);

        listTabs.forEach((key) => {
            if (data.config.tabs[key].fields) {
                listFieldInTabs = [...listFieldInTabs, ...data.config.tabs[key].fields];
            }
        });

        listFieldNotIntabs = listFieldNotIntabs.filter(x => listFieldInTabs.indexOf(x) === -1 && !data.config.fields[x].hidden);

    }

    const handleChangeTab = (i) => {
        setTableCurrent({
            ...tabCurrent,
            [postType]: i
        });
    };

    return (
        <Grid
            container
            spacing={4}>
            <Grid item md={12} xs={12}>

                <Grid
                    container
                    spacing={3}>
                    {
                        Boolean(listFieldNotIntabs.length) &&
                        <Grid item md={12} xs={12}>
                            <Card>
                                <CardContent>
                                    <Grid
                                        container
                                        spacing={4}>
                                        {
                                            listFieldNotIntabs.map(key => (
                                                !data.config.fields[key].hidden ?
                                                    <Grid item md={12} xs={12} key={key} >
                                                        <FieldForm
                                                            compoment={data.config.fields[key].view}
                                                            config={data.config.fields[key]}
                                                            post={data.post}
                                                            name={key}
                                                            onReview={(value, key2 = key) => onReview(value, key2)}
                                                        />
                                                    </Grid>
                                                    :
                                                    <React.Fragment key={key}></React.Fragment>
                                            ))
                                        }
                                    </Grid>
                                </CardContent>
                            </Card>
                        </Grid>
                    }
                    {
                        Boolean(listFieldInTabs.length) &&
                        <Grid item md={12} xs={12}>
                            <Card>
                                <CardContent>
                                    {
                                        Boolean(data.config.tabs) &&
                                        <div className={classes.root}>
                                            <div className={classes.tabs}>
                                                <span className='indicator' style={{ top: tabCurrent[postType] * 48 }}></span>
                                                {
                                                    listTabs.map((g, i) => (
                                                        <Button key={g} onClick={e => handleChangeTab(i)} name={i} className={classes.tabsItem + (tabCurrent[postType] === i ? ' active' : '')} color="default">{data.config.tabs[g].title}</Button>
                                                    ))
                                                }
                                            </div>
                                            <div style={{ paddingLeft: 24, width: 'calc( 100% - 160px )' }}>
                                                <Grid
                                                    container
                                                    spacing={4}>
                                                    {
                                                        (() => {

                                                            if (listTabs[tabCurrent[postType]]) {

                                                                if (data.config.tabs[listTabs[tabCurrent[postType]]].hook) {
                                                                    return <Grid item md={12} xs={12}><Hook
                                                                        {...props}
                                                                        {...data.config.tabs[listTabs[tabCurrent[postType]]]}
                                                                        onReview={onReview}
                                                                    /></Grid>
                                                                } else if (data.config.tabs[listTabs[tabCurrent[postType]]].fields) {

                                                                    return data.config.tabs[listTabs[tabCurrent[postType]]].fields.map(key => (
                                                                        <Grid item md={12} xs={12} key={key}>
                                                                            <FieldForm
                                                                                compoment={data.config.fields[key].view}
                                                                                config={data.config.fields[key]}
                                                                                post={data.post}
                                                                                name={key}
                                                                                onReview={(value, key2 = key) => onReview(value, key2)}
                                                                            />
                                                                        </Grid>
                                                                    ))
                                                                }

                                                                return data.config.tabs[listTabs[tabCurrent[postType]]].compoment;

                                                            } else {
                                                                setTableCurrent({
                                                                    ...tabCurrent,
                                                                    [postType]: 0
                                                                });
                                                            }
                                                        })()

                                                    }

                                                </Grid>
                                            </div>
                                        </div>
                                    }
                                </CardContent>
                            </Card>
                        </Grid>
                    }
                    <Hook hook="PostType/CreateData" data={data} onUpdateData={onUpdateData} postType={postType} />
                </Grid>
            </Grid>
        </Grid>
    )
    
}

export default Form
