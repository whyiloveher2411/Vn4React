import { Typography } from '@material-ui/core'
import React from 'react'

function Header({ subTitle, title }) {
    return (
        <div>
            <Typography component="h2" gutterBottom variant="overline">
                {subTitle}
            </Typography>
            <Typography component="h1" variant="h3">
                {title}
            </Typography>
        </div>
    )
}

export default Header
