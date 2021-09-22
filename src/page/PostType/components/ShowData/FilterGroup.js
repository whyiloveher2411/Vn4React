import {
    Button, IconButton, ListItemIcon, ListItemText,
    Menu,
    MenuItem, Tooltip,
    Typography
} from '@material-ui/core';
import FilterListRoundedIcon from '@material-ui/icons/FilterListRounded';
import { makeStyles } from '@material-ui/styles';
import { MaterialIcon } from 'components';
import React from 'react';
import { FilterSetting } from './SearchBar/components';

const useStyles = makeStyles((theme) => (
    {
        active: {
            backgroundColor: theme.palette.primary.main,
            color: theme.palette.primary.contrastText,
            '&:hover': {
                backgroundColor: theme.palette.primary.dark,
            },
            '& .MuiListItemIcon-root, & .MuiTypography-body1':{
                color: theme.palette.primary.contrastText,
            }
        },
        btnWarpper: {
            position: 'relative',
            overflow: 'hidden',
            height: 56,
            whiteSpace: 'nowrap',
            '&>.indicator': {
                borderRadius: 50,
                backgroundColor: '#3f51b5',
                position: 'absolute',
                right: 0,
                bottom: -15,
                height: 17,
                width: 200,
                transition: 'all 300ms cubic-bezier(0.4, 0, 0.2, 1) 0ms',
                [theme.breakpoints.down('md')]: {
                    display: 'none'
                },

            },
        },
        button: {
            color: '#5f6368',
            height: 56,
            width: 200,
            justifyContent: 'flex-start',
            textTransform: 'initial',
            '&.active': {
                color: 'var(--color)',
                '& $icon': {
                    color: 'var(--color)',
                }
            },
            [theme.breakpoints.down('md')]: {
                display: 'none'
            },
        },
        icon: {
            color: '#5f6368',
            height: 20,
            margin: '0 8px',
        }
    }
));

function FilterGroup({ options, setQueryUrl, queryUrl, data, acctionPost, onFilter }) {

    const classes = useStyles()
    const moreRef = React.useRef(null);
    const [openMenu, setOpenMenu] = React.useState(false);
    const [, setListFilterHeader] = React.useState([]);

    const [tabCurrent, setTableCurrent] = React.useState(-1);
    const handleMenuOpen = () => {
        setOpenMenu(true)
    }

    const handleMenuClose = () => {
        setOpenMenu(false)
    }

    const handleFilter = key => {
        setOpenMenu(false);
        setQueryUrl({
            ...queryUrl,
            filter: key
        });
    };

    const [openFilter, setOpenFilter] = React.useState(false)

    const handleFilterOpen = () => {
        setOpenFilter(true)
    }

    const handleFilterClose = () => {
        setOpenFilter(false)
    }

    React.useEffect(() => {

        if (options.filters) {

            let listFilterHeader = Object.keys(options.filters).filter(key => !options.filters[key].delete && options.filters[key].showOnHeader && options.filters[key].count > 0);
            let tabCurrent = -1;
            if (options.filters[queryUrl.filter] && listFilterHeader.indexOf(queryUrl.filter) !== -1) {
                tabCurrent = {
                    key: queryUrl.filter,
                    index: listFilterHeader.indexOf(queryUrl.filter)
                };
            }
            setListFilterHeader(listFilterHeader);
            setTableCurrent(tabCurrent);

        }

    }, [options]);

    return (
        <>
            <Typography variant="h5" style={{ display: 'flex', alignItems: 'center' }}>
                <Tooltip title="More filters">
                    <IconButton
                        onClick={handleMenuOpen}
                        ref={moreRef}
                        size="small">
                        <FilterListRoundedIcon />
                    </IconButton>
                </Tooltip>
                {
                    Boolean(options.filters && options.filters.all.count) &&
                    <Menu
                        anchorEl={moreRef.current}
                        classes={{ paper: classes.menu }}
                        onClose={handleMenuClose}
                        open={openMenu}>
                        {
                            Object.keys(options.filters).map(key => (
                                !options.filters[key].delete && options.filters[key].count ?
                                    <MenuItem key={key} className={queryUrl.filter === key ? classes.active : ''} onClick={e => handleFilter(key)} >
                                        {
                                            options.filters[key].icon &&
                                            <ListItemIcon>
                                                <MaterialIcon icon={options.filters[key].icon} />
                                            </ListItemIcon>
                                        }
                                        <ListItemText disableTypography primary={<Typography type="body2" dangerouslySetInnerHTML={{ __html: `${options.filters[key].title} (${options.filters[key].count})` }}></Typography>} />
                                    </MenuItem>
                                    : <li key={key}></li>
                            ))
                        }
                        <MenuItem onClick={handleFilterOpen}>
                            <ListItemIcon>
                                <MaterialIcon icon='SettingsOutlined' />
                            </ListItemIcon>
                            <ListItemText disableTypography primary={<Typography type="body2">Settings</Typography>} />
                        </MenuItem>
                    </Menu>
                }
                {
                    Boolean(data) &&
                    <FilterSetting
                        data={data}
                        acctionPost={acctionPost}
                        onClose={handleFilterClose}
                        onFilter={onFilter}
                        open={openFilter}
                    />
                }

                <div className={classes.btnWarpper}>

                    {
                        Boolean(options.filters && options.filters[queryUrl.filter]) &&
                        <Button
                            ref={moreRef}
                            onClick={handleMenuOpen}
                            style={{ '--color': options.filters[queryUrl.filter].color }}
                            className={classes.button + ' active'}>
                            {options.filters[queryUrl.filter].icon && <MaterialIcon icon={options.filters[queryUrl.filter].icon} className={classes.icon} />}
                            <span dangerouslySetInnerHTML={{ __html: `${options.filters[queryUrl.filter].title} (${options.filters[queryUrl.filter].count})` }} />
                        </Button>
                    }
                    {/*                     
                    {
                        Boolean(options.filters) &&
                        Object.keys(options.filters).filter(key => !options.filters[key].delete && options.filters[key].showOnHeader && options.filters[key].count > 0).map((key, index) => (
                            <Button
                                onClick={() => {
                                    setQueryUrl({
                                        ...queryUrl,
                                        filter: key
                                    });
                                    setTableCurrent({
                                        key: key,
                                        index: index
                                    });
                                }}
                                key={key}
                                style={{ '--color': options.filters[key].color }}
                                className={classes.button + ' ' + (queryUrl.filter === key ? 'active' : '')}>
                                {options.filters[key].icon && <MaterialIcon icon={options.filters[key].icon} className={classes.icon} />}
                                <span dangerouslySetInnerHTML={{ __html: `${options.filters[key].title} (${options.filters[key].count})` }} />
                            </Button>
                        ))
                    } */}
                    <span className='indicator' style={tabCurrent === -1 ? { left: 0, width: 0 } : { left: 0, background: options.filters[tabCurrent.key]?.color }}></span>
                </div>
            </Typography>
        </>
    )
}

export default FilterGroup
