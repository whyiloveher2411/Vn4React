import { Grid } from '@material-ui/core'
import { makeStyles } from '@material-ui/styles'
import React from 'react'
import { Search } from './components'

const useStyles = makeStyles(() => ({
    root: {
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'space-between',
        flexWrap: 'wrap',
    },
    search: {
        flexGrow: 1,
        maxWidth: 480,
        flexBasis: 480,
    },
}))

const SearchBar = (props) => {

    const { onSearch, className, onValue, ...rest } = props

    const classes = useStyles()

    return (
        <Grid
            {...rest}
            className={classes.root + ' ' + className}
            container
            spacing={3}>
            <Grid item>
                <Search className={classes.search} onValue={onValue} onSearch={onSearch} />
            </Grid>
            <Grid item>

            </Grid>
        </Grid>
    )
}

export default SearchBar
