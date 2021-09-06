import { Box, FormControl, IconButton, InputLabel, makeStyles, Menu, MenuItem, Typography } from '@material-ui/core'
import React from 'react'
import AddCircleIcon from '@material-ui/icons/AddCircle';
import FieldForm from 'components/FieldForm'
import { useAjax } from 'utils/useAjax';
import HighlightOffRoundedIcon from '@material-ui/icons/HighlightOffRounded';

const useStyles = makeStyles((theme) => ({
    selectChoose: {
        margin: '0 4px',
        textDecoration: 'underline',
        cursor: 'pointer',
        fontWeight: 'bold',
    },
    field: {
        margin: '0 4px',
        fontWeight: 'bold',
    },
    buttonAddC: {
        color: theme.palette.buttonSave.main
    },
    conditions: {
        flexGrow: 1,
    },
    content: {
        paddingLeft: 16,
        borderLeft: '2px dotted #dedede',
    }
}));


const comparisonOperators = {
    '=': {
        title: 'is'
    },
    '!=': {
        title: 'is not'
    },
    '>=': {
        title: 'equals or greater than'
    },
    '<=': {
        title: 'equals or less than'
    },
    '>': {
        title: 'greater than'
    },
    '<': {
        title: 'less than'
    },
    '{}': {
        title: 'contains'
    },
    '!{}': {
        title: 'does not contain'
    },
    '()': {
        title: 'is one of'
    },
    '!()': {
        title: 'is not one of'
    },
    'IS NULL': {
        title: 'is NULL',
        isVoid: true,
    },
    'IS NOT NULL': {
        title: 'is not NULL',
        isVoid: true,
    },
};

function PostTypeConditions({ post, name, config, onReview, handelRemove }) {

    const classes = useStyles();

    const ajax = useAjax();

    const [listMenu, setListMenu] = React.useState({ });

    const [fields, setFields] = React.useState(false);

    const [eventClickMenu, setEventClickMenu] = React.useState(null);
    const [indexChangeValue, setIndexChangeValue] = React.useState(false);

    const [data, setData] = React.useState(post[name] ? post[name] : {
        type: 'all',
        value: 1,
        content: []
    });

    const [showButtonAdd, setShowButtonAdd] = React.useState(true);

    const [anchorEl, setAnchorEl] = React.useState(null);

    React.useEffect(() => {
        // console.log(post);
        if (!fields) {
            ajax.ajax({
                url: 'post-type/get-conditions',
                data: {
                    type: config.type
                },
                success: (result) => {
                    if (result.fields) {
                        setFields({
                            'conditions_combination': {
                                title: 'Conditions Combination',
                            },
                            ...result.fields
                        });
                    }
                }
            })
        }
    }, []);

    const handleClickSelect = (event, menus, eventClickItem) => {
        setEventClickMenu(() => eventClickItem);
        setListMenu(menus);
        setAnchorEl(event.currentTarget);
    };

    const handleClose = () => {
        setAnchorEl(null);
    };

    const handleMenuConditionsType = (e, value) => {
        handleClickSelect(e,
            { all: 'All', any: 'Any' },
            (value) => {
                setData(prev => ({ ...prev, type: value }));
                handleClose();
            }
        )
    };

    const handleMenuConditionsValue = (e) => {
        handleClickSelect(e,
            { true: 'True', false: 'False' },
            (value) => {
                setData(prev => ({ ...prev, value: value === 'true' ? 1 : 0 }));
                handleClose();
            }
        )
    };

    const handleMenuComparisonOperators = (e, index) => {
        let menuItems = [];

        Object.keys(comparisonOperators).forEach(key => {
            menuItems[key] = comparisonOperators[key].title;
        });

        handleClickSelect(e,
            menuItems,
            (value) => {
                setData(prev => {
                    prev.content[index].comparisonOperators = value;
                    return { ...prev };
                });
                handleClose();
            }
        )
    }

    React.useEffect(() => {
        onReview(data);
    }, [data]);


    return (
        <>
            <Box width={1} className={classes.root} position="relative" display="flex" alignItems="baseline" gridGap={16}>
                {
                    Boolean(config.title) &&
                    <InputLabel>{config.title}</InputLabel>
                }
                <div className={classes.conditions}>
                    <Box display="flex" alignItems="center">
                        <Typography>If
                            <span onClick={handleMenuConditionsType} className={classes.selectChoose}>
                                {data.type === 'all' ? 'All' : 'Any'}
                            </span>
                            of these conditions are
                            <span onClick={handleMenuConditionsValue} className={classes.selectChoose}>
                                {data.value === 1 ? 'True' : 'False'}
                            </span>
                            :</Typography>

                        {
                            Boolean(config.removeButton) &&
                            <IconButton size="small" color="secondary" onClick={handelRemove}>
                                <HighlightOffRoundedIcon />
                            </IconButton>
                        }
                    </Box>
                    <Box display="flex" flexDirection="column" alignItems="flex-start" gridGap={8} paddingTop={2} className={classes.content}>

                        {
                            Boolean(fields) &&
                            data.content.map((item, index) => (
                                fields[item.field] ?
                                    (
                                        item.field === 'conditions_combination' ?
                                            <FieldForm
                                                compoment="PostTypeConditions"
                                                config={{
                                                    ...config,
                                                    title: false,
                                                    removeButton: true,
                                                }}
                                                style={{ width: '100%' }}
                                                handelRemove={() => setData(prev => {
                                                    prev.content.splice(index, 1);
                                                    return { ...prev };
                                                })}
                                                post={{ conditions: item.value }}
                                                name="conditions"
                                                onReview={(value) => {
                                                    setData(prev => {
                                                        prev.content[index].value = value;
                                                        return { ...prev };
                                                    });
                                                }}
                                            />
                                            :
                                            <Box whiteSpace="nowrap" gridGap={8} height={38} display="flex" alignItems="center" key={index}>
                                                <Box display="flex" alignItems="center">
                                                    <Typography>{fields[item.field].title}
                                                        <span onClick={(e) => handleMenuComparisonOperators(e, index)} className={classes.selectChoose}>
                                                            {comparisonOperators[item.comparisonOperators].title}
                                                        </span>
                                                    </Typography>
                                                    {
                                                        !comparisonOperators[item.comparisonOperators].isVoid ?
                                                            indexChangeValue === index ?
                                                                <FieldForm
                                                                    compoment="text"
                                                                    config={{
                                                                        title: false,
                                                                        size: 'small',
                                                                    }}
                                                                    post={{ value: item.value }}
                                                                    name="value"
                                                                    onReview={() => { }}
                                                                    onBlur={e => {

                                                                        let value = e.currentTarget.value;

                                                                        if (fields[item.field]?.view === 'number') {
                                                                            value = parseInt(value);
                                                                        }

                                                                        setData(prev => {
                                                                            prev.content[index].value = e.currentTarget.value;
                                                                            return { ...prev };
                                                                        });
                                                                        setIndexChangeValue(false);
                                                                    }}
                                                                />
                                                                :
                                                                <span onClick={(e) => setIndexChangeValue(index)} className={classes.selectChoose}>
                                                                    {
                                                                        Boolean(item.value) ? item.value : '...'
                                                                    }
                                                                </span>
                                                            : <></>
                                                    }
                                                </Box>
                                                <IconButton size="small" color="secondary" onClick={() => {
                                                    setData(prev => {
                                                        prev.content.splice(index, 1);
                                                        return { ...prev };
                                                    })

                                                }}>
                                                    <HighlightOffRoundedIcon />
                                                </IconButton>
                                            </Box>
                                    )
                                    : <React.Fragment key={index}></React.Fragment>
                            ))
                        }

                        {
                            showButtonAdd ?
                                <IconButton onClick={() => setShowButtonAdd(false)} className={classes.buttonAddC}>
                                    <AddCircleIcon />
                                </IconButton>
                                :
                                <Box width={1} gridGap={8} display="flex" alignItems="center">
                                    <FieldForm
                                        compoment="select"
                                        config={{
                                            title: 'condition',
                                            list_option: fields
                                        }}
                                        post={{ }}
                                        name="field"
                                        onReview={(value) => {
                                            if (value) {
                                                setData(prev => ({ ...prev, content: [...prev.content, { field: value, comparisonOperators: '=', value: '' }] }))
                                                setShowButtonAdd(true);
                                            }
                                        }}
                                    />
                                    <IconButton color="secondary" onClick={() => setShowButtonAdd(true)}>
                                        <HighlightOffRoundedIcon />
                                    </IconButton>
                                </Box>
                        }

                    </Box>



                    {/* <FieldForm
                        compoment={'repeater'}
                        config={{
                            title: '',
                            sub_fields: {

                            }
                        }}
                        post={post}
                        name={'filters'}
                        onReview={(value, key2 = 'filters') => onReview(value, key2)}
                    /> */}
                </div>
            </Box>

            <Menu
                id="conditions_type"
                anchorEl={anchorEl}
                keepMounted
                open={Boolean(anchorEl)}
                onClose={handleClose}
            >
                {
                    Object.keys(listMenu).map(key => (
                        <MenuItem
                            key={key}
                            onClick={() => eventClickMenu(key)}
                        >
                            {listMenu[key]}
                        </MenuItem>
                    ))
                }
            </Menu>

            {/* <Menu
                id="conditions_value"
                anchorEl={anchorElValue}
                keepMounted
                open={Boolean(anchorElValue)}
                onClose={() => setAnchorElValue(null)}
                anchorOrigin={{
                    vertical: 'bottom',
                    horizontal: 'center',
                }}
                transformOrigin={{
                    vertical: 'top',
                    horizontal: 'center',
                }}
            >
                <MenuItem
                    onClick={() => handleMenuConditionsValue(1)}
                >
                    True
                </MenuItem>
                <MenuItem
                    onClick={() => handleMenuConditionsValue(0)}
                >
                    False
                </MenuItem>
            </Menu> */}

        </>
    )
}

export default PostTypeConditions
