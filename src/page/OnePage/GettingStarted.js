import { Typography } from '@material-ui/core'
import { makeStyles } from '@material-ui/styles'
import { Markdown } from 'components'
import { PageHeaderSticky } from 'components/Page'
import React, { useEffect, useState } from 'react'
import { __ } from 'utils/i18n'

const useStyles = makeStyles((theme) => ({
    markdownContainer: {
        maxWidth: 700,
        color: theme.palette.text.primary,
    },
}))

const GettingStarted = () => {

    const classes = useStyles();

    const [source, setSource] = useState('')

    useEffect(() => {
        fetch('/docs/GettingStarted.md')
            .then((response) => response.text())
            .then((text) => setSource(text))
    }, [])

    return (
        <PageHeaderSticky
            className={classes.root}
            title={__('Getting Started')}
            header={
                <>
                    <Typography gutterBottom variant="overline">
                        {__('Development')}
                    </Typography>
                    <Typography variant="h3">{__('Getting Started')}</Typography>
                </>
            }
        >
            {source && (
                <div className={classes.markdownContainer}>
                    <Markdown
                        escapeHtml={false}
                        source={source} //
                    />
                </div>
            )}
        </PageHeaderSticky>
    )
}

export default GettingStarted
