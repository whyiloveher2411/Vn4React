import {
    Input,
    List,
    ListItem,
    ListItemIcon,
    ListItemText
} from "@material-ui/core";
import ClickAwayListener from "@material-ui/core/ClickAwayListener";
import Paper from "@material-ui/core/Paper";
import Popper from "@material-ui/core/Popper";
import { makeStyles } from "@material-ui/core/styles";
import SearchIcon from "@material-ui/icons/Search";
import React from "react";
import { Link } from "react-router-dom";
import { __ } from "utils/i18n";
import { useAjax } from "utils/useAjax";

const useStyles = makeStyles((theme) => ({
    search: {
        backgroundColor: "rgba(255,255,255, 0.1)",
        borderRadius: 4,
        flexBasis: 300,
        height: 36,
        padding: theme.spacing(0, 2),
        display: "flex",
        alignItems: "center",
        marginLeft: theme.spacing(2),
        [theme.breakpoints.down("xs")]: {
            display: "none",
        },
    },
    searchIcon: {
        marginRight: theme.spacing(2),
        color: "inherit",
    },
    searchInput: {
        flexGrow: 1,
        color: "inherit",
        "& input::placeholder": {
            opacity: 1,
            color: "inherit",
        },
    },
    searchPopper: {
        zIndex: theme.zIndex.appBar + 100,
    },
    searchPopperContent: {
        marginTop: theme.spacing(1),
        maxHeight: '80vh',
        overflow: 'auto',
        minWidth: 300,
        maxWidth: '100%',
        '& a': {
            color: theme.palette.primary.main
        }
    },
}));

export default function Search() {

    const classes = useStyles();

    const searchRef = React.useRef(null);

    const [openSearchPopover, setOpenSearchPopover] = React.useState(false);

    const [searchValue, setSearchValue] = React.useState("");

    const useAjax1 = useAjax({ loadingType: 'custom' });

    const [popularSearches, setPopularSearches] = React.useState([]);

    const handleSearchkeypress = (event) => {
        useAjax1.ajax({
            url: "search/get",
            method: "POST",
            isGetData: false,
            data: {
                search: event.target.value,
            },
            success: (result) => {
                if (result.data && result.data.length) {
                    setOpenSearchPopover(true);
                    setPopularSearches(result.data);
                } else {
                    setOpenSearchPopover(true);
                    setPopularSearches([
                        { title: 'Data not found.' }
                    ]);
                }
            },
        });
    };

    const handleSearchChange = (event) => {
        setSearchValue(event.target.value);
    };

    const handleSearchPopverClose = () => {
        setOpenSearchPopover(false);
    };

    return (
        <>
            <div className={classes.search} ref={searchRef}>
                <SearchIcon className={classes.searchIcon} />
                <Input
                    className={classes.searchInput}
                    disableUnderline
                    onKeyPress={(e) => {
                        if (e.key === 'Enter') handleSearchkeypress(e);
                    }}
                    onChange={handleSearchChange}
                    placeholder={__('Enter something...')}
                    value={searchValue}
                />
            </div>
            <Popper
                anchorEl={searchRef.current}
                className={classes.searchPopper}
                open={openSearchPopover}
                transition
            >
                <ClickAwayListener onClickAway={handleSearchPopverClose}>
                    <Paper className={classes.searchPopperContent + ' custom_scroll'} elevation={3}>
                        <List>
                            {popularSearches.map((search, index) => (
                                <Link key={search.link} to={search.link}>
                                    <ListItem
                                        button
                                        onClick={handleSearchPopverClose}
                                    >
                                        <ListItemIcon>
                                            <SearchIcon />
                                        </ListItemIcon>
                                        <ListItemText primary={search.title_type ? '[' + search.title_type + '] ' + search.title : search.title} />
                                    </ListItem>
                                </Link>
                            ))}
                        </List>
                    </Paper>
                </ClickAwayListener>
            </Popper>
        </>
    );
}
