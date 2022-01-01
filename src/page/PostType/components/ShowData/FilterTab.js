import { Box, IconButton, makeStyles, Typography } from '@material-ui/core';
import Button from '@material-ui/core/Button';
import { MaterialIcon } from 'components';
import React from 'react';
import { addClasses } from 'utils/dom';
import { fade } from '@material-ui/core/styles/colorManipulator';
import { __ } from 'utils/i18n';

const useStyles = makeStyles((theme) => ({
    tabsItem: {
        padding: '6px 16px',
        whiteSpace: 'nowrap',
    },
    tabs: {
        background: theme.palette.body.background,
        display: 'flex',
        flexDirection: 'column',
        position: 'relative',
        '--color': theme.palette.primary.main,
        '&>.indicator': {
            position: 'absolute',
            top: 0,
            right: 0,
            width: 2,
            height: 48,
            transition: 'all 300ms cubic-bezier(0.4, 0, 0.2, 1) 0ms',
            background: 'var(--color)',
        },
        '&>button': {
            minWidth: 160,
            minHeight: 48,
            opacity: 0.7,
            '&.active': {
                background: 'var(--activeColor)',
            },
            '&.active, &.active $counter, &.active $filterTitle': {
                opacity: 1,
                color: 'var(--color)',
                fontWeight: 'bold',
            },
        },
        '& .MuiButton-label': {
            justifyContent: 'left',
            display: 'flex',
            alignItems: 'flex-start'
        }
    },
    filterTitle: {
        width: '100%',
        textAlign: 'left',
        textTransform: 'none',
    },
    counter: {
        lineHeight: '24.5px',
        paddingLeft: 8
    },
    tabsIcon: {
        '&>button': {
            minWidth: 0,
            minHeight: 0,
            height: 48,
        },
    },
}));

function FilterTab({ name, tabs, options, queryUrl, setQueryUrl, ...props }) {

    const classes = useStyles();

    const [tabCurrent, setTableCurrent] = React.useState({
        [name]: queryUrl.filter,
    });

    const handleChangeTab = (i) => {
        setTableCurrent({ ...tabCurrent, [name]: i });
        if (props.onChangeTab) {
            props.onChangeTab(i);
        }
    };

    React.useEffect(() => {
        setTableCurrent({
            [name]: queryUrl.filter,
        });
    }, [name, queryUrl.filter]);

    const filters = options.filters ? Object.keys(options.filters).filter(key => !options.filters[key].delete && options.filters[key].count > 0) : [];

    const tabSelectedIndex = filters.findIndex(item => item === tabCurrent[name]);

    if (Boolean(options.filters)) {
        return (
            <div
                className={addClasses({
                    [classes.tabs]: true,
                    [classes.tabsIcon]: true,
                })}
                style={{ '--activeColor': options.filters[tabCurrent[name]]?.color ? fade(options.filters[tabCurrent[name]].color, 0.08) : 'rgba(228, 230, 235, 0.08)' }}
            >
                <span className='indicator' style={{ top: (tabSelectedIndex !== -1 ? tabSelectedIndex : 0) * 48 }}></span>
                {
                    filters.map((key) => (
                        <Button
                            key={key}
                            onClick={() => {
                                setQueryUrl({
                                    ...queryUrl,
                                    filter: key
                                });
                                handleChangeTab(key)
                            }}
                            className={addClasses({
                                [classes.tabsItem]: true,
                                active: tabCurrent[name] === key,
                            })}
                            startIcon={<MaterialIcon icon={options.filters[key].icon} className={classes.icon} />}
                            style={{ '--color': options.filters[key].color }}
                            color="default"
                        >
                            <Typography noWrap className={classes.filterTitle} dangerouslySetInnerHTML={{ __html: options.filters[key].title }} />
                            <Typography className={classes.counter} variant='body2'>{options.filters[key].count}</Typography>
                        </Button>
                    ))
                }
            </div>
        )
    }

    return <></>

}

export default FilterTab
