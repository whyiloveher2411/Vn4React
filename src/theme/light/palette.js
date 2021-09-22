import { colors } from '@material-ui/core'

const white = '#FFFFFF'
const black = '#000000'

// eslint-disable-next-line import/no-anonymous-default-export
export default {
    type: 'light',
    black,
    white,
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
        primary: '#263238',
        secondary: '#546e7a',
        third: '#607d8b',
        link: '#1e88e5',
    },
    buttonSave: {
        contrastText: white,
        dark: colors.green[900],
        main: colors.green[600],
        light: colors.green[100],
    },
    link: colors.blue[800],
    icon: colors.blueGrey[600],
    background: {
        default: '#F4F6F8',
        paper: white,
        selected: '#f6f7f9',
    },
    divider: colors.grey[200],
    dividerDark: '#e0e0e0',
    body:{
        background: '#f4f6f8'
    },
    header:{
        background: '#3f51b5'
    },
    menu:{
        background: '#fff'
    },
    fileSelected: '#d4d4d4',
}
