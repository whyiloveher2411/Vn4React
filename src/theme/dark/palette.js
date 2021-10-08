import { colors } from '@material-ui/core'

const white = '#FFFFFF'

// eslint-disable-next-line import/no-anonymous-default-export
export default {
    type: 'dark',
    primary: {
        contrastText: white,
        dark: colors.indigo[900],
        main: colors.indigo[500],
        light: colors.indigo[100],
    },
    secondary: {
        contrastText: white,
        dark: colors.red[900],
        main: colors.red[700],
        light: colors.red[100],
    },
    success:{
        contrastText: white,
        dark: colors.green[900],
        main: colors.green[600],
        light: colors.green[100],
    },
    error: {
        contrastText: white,
        dark: colors.red[900],
        main: colors.red[600],
        light: colors.red[400],
    },
    text: {
        primary: '#e4e6eb',
        secondary: '#b0b3b8',
        third: '#989898',
        link: '#90caf9',
    },
    buttonSave: {
        contrastText: white,
        dark: colors.green[900],
        main: colors.green[600],
        light: colors.green[100],
    },
    link: colors.blue[800],
    icon: '#fff',
    background: {
        default: '#303030',
        paper: '#242526',
        selected: '#484848',
    },
    divider: '#353535',
    dividerDark: '#353535',
    body: {
        background: '#181818'
    },
    header: {
        background: '#424242'
    },
    menu: {
        background: '#242526'
    },
    fileSelected: '#484848',
}
