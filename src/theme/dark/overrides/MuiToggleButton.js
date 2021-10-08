import { colors } from '@material-ui/core'

import palette from '../palette'

export default {
    root: {
        color: palette.icon,
        '&:hover': {
            backgroundColor: palette.divider
        },
        '&$selected': {
            backgroundColor: palette.dividerDark,
            '&:hover': {
                backgroundColor: palette.dividerDark
            },
        },
        '&:first-child': {
            borderTopLeftRadius: 4,
            borderBottomLeftRadius: 4,
        },
        '&:last-child': {
            borderTopRightRadius: 4,
            borderBottomRightRadius: 4,
        },
    },
}
