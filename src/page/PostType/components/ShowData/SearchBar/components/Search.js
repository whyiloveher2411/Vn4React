import React, { useState } from 'react'
import PropTypes from 'prop-types'
import clsx from 'clsx'
import { makeStyles } from '@material-ui/styles'
import { Paper, Button, Input } from '@material-ui/core'
import SearchIcon from '@material-ui/icons/Search'
import { __ } from 'utils/i18n'

const useStyles = makeStyles((theme) => ({
    root: {
        display: 'flex',
        alignItems: 'center',
    },
    search: {
        flexGrow: 1,
        height: 42,
        padding: theme.spacing(0, 2),
        display: 'flex',
        alignItems: 'center',
    },
    searchIcon: {
        marginRight: theme.spacing(2),
        color: theme.palette.icon,
    },
    searchInput: {
        flexGrow: 1,
    },
    searchButton: {
        marginLeft: theme.spacing(2),
    },
}))

const Search = (props) => {
    const { onSearch, className, onValue, ...rest } = props

    const [inputValue, setInputValue] = useState(onValue);

    const classes = useStyles()

    const clickSearch = (e) => {
        console.log(e);
        onSearch(inputValue);
    };

    React.useEffect(() => {
        setInputValue(onValue);
    }, [onValue]);

    return (
        <div {...rest} className={clsx(classes.root, className)}>
            <Paper className={classes.search} elevation={1}>
                <SearchIcon className={classes.searchIcon} />
                <Input
                    className={classes.searchInput}
                    onChange={e => { setInputValue(e.target.value) }}
                    onKeyPress={e => { if (e.key === 'Enter') clickSearch(e) }}
                    disableUnderline
                    placeholder={__('Enter something...')}
                    value={inputValue}
                />
            </Paper>
            <Button
                className={classes.searchButton}
                onClick={clickSearch}
                size="large"
                variant="contained">
                {__('Search')}
            </Button>
        </div>
    )
}

Search.propTypes = {
    className: PropTypes.string,
    onSearch: PropTypes.func,
}

export default Search
