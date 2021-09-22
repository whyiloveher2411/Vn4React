import { colors, Typography } from '@material-ui/core'
import { makeStyles } from '@material-ui/styles'
import { Markdown } from 'components'
import { PageHeaderSticky } from 'components/Page'
import React, { useEffect, useState } from 'react'

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
            title="Getting Started"
            header={
                <>
                    <Typography gutterBottom variant="overline">
                        Development
                    </Typography>
                    <Typography variant="h3">Getting Started</Typography>
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
