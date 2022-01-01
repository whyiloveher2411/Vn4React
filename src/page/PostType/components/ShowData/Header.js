import { Box, Fab, Grid, IconButton, Tooltip, Typography } from '@material-ui/core'
import AddRoundedIcon from '@material-ui/icons/AddRounded'
import ArrowBackOutlined from '@material-ui/icons/ArrowBackOutlined';
import { makeStyles } from '@material-ui/styles'
import clsx from 'clsx'
import PropTypes from 'prop-types'
import React from 'react'
import { Link, useHistory } from 'react-router-dom'
import { __ } from 'utils/i18n'
import { usePermission } from 'utils/user'

const useStyles = makeStyles((theme) => ({
    root: {
        marginBottom: theme.spacing(3)
    },
}))

const Header = (props) => {
    const { className, config, singularName, type, ...rest } = props

    const classes = useStyles();

    const history = useHistory();

    return (
        <div {...rest} className={clsx(classes.root, className)}>
            <Grid
                alignItems="flex-end"
                container
                justify="space-between"
                spacing={3}>
                <Grid item>
                    {
                        Boolean(config?.admin?.back_link) ?
                            <Typography variant="h2" style={{ fontWeight: 'normal' }} color="initial">
                                <Box display="flex" alignItems="center">
                                    <Tooltip title={__('Back')} aria-label="back">
                                        <IconButton onClick={() => history.push(config?.admin?.back_link)} >
                                            <ArrowBackOutlined />
                                        </IconButton>
                                    </Tooltip>
                                    &nbsp;  {config?.label.name}
                                </Box>
                            </Typography>
                            :
                            <>
                                <Typography component="h2" gutterBottom variant="overline">
                                    {__('Content')}
                                </Typography>
                                <Typography component="h1" variant="h3">
                                    {config?.label.name ?? '...'}
                                </Typography>
                            </>
                    }
                </Grid>
            </Grid>
        </div >
    )
}

Header.propTypes = {
    className: PropTypes.string,
    label: PropTypes.object.isRequired
}

Header.defaultProps = {
    label: {
        name: '...',
        singularName: '...',
    }
}


export default Header
