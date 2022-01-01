import { colors } from '@material-ui/core'

export default {
    deletable: {
        '&:focus': {
            backgroundColor: colors.blueGrey[300],
        },
    },
    deleteIcon: {
        color: 'inherit',
        '&:hover': {
            color: 'initial'
        }
    }
}
