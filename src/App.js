import { LinearProgress } from '@material-ui/core';
import { makeStyles } from '@material-ui/core/styles';
import { ThemeProvider } from '@material-ui/styles';
import CustomSnackbar from 'components/CustomSnackbar';
import { SnackbarProvider } from 'notistack';
import React, { lazy, Suspense } from 'react';
import { useSelector } from 'react-redux';
import {
  BrowserRouter as Router,
  Route, Switch
} from "react-router-dom";
import './App.css';
import Header from './layout/Header';
import Login from './page/login/Login';
import Install from 'page/Install/Install';
import RequireLogin from 'layout/RequireLogin';
import AppMenu from './layout/AppMenu';
import './utils/i18n';

const useStyles = makeStyles({
  root: {
    flex: '1 1 auto',
    display: 'flex',
    overflow: 'hidden',
  },
  warperMain: {
    width: '100%',
    height: '100%',
    overflowY: 'auto',
  },
  main: {
    position: 'relative',
    minHeight: 'calc(100% + 0.5px)'
  },
});

// var old = alert;

// alert = function () {
//   console.log(new Error().stack);
//   old.apply(window, arguments);
// };

function App() {

  const classes = useStyles();
  const user = useSelector(state => state.user);
  const theme = useSelector(state => state.theme);

  return (
    <ThemeProvider theme={{ ...theme }}>
      <SnackbarProvider
        maxSnack={5}
        content={(key, message) => (
          <CustomSnackbar id={key} message={message} />
        )}
      >
        <div className="App" style={{ background: theme.palette.body.background }}>
          {
            user.state === 'identify' &&
            <Router>
              <Header />
              <div className={classes.root}>
                <AppMenu />
                <div id="warperMain" className={classes.warperMain + ' custom_scroll'}>
                  <Suspense fallback={<LinearProgress />}>
                    <main className={classes.main}>
                      <Switch>
                        <Route path='/post-type/:type/:action' component={lazy(() => import('./page/PostType/PostType'))} />
                        <Route exact path='/plugin/:plugin/:tab?/:subtab?' component={lazy(() => import('./page/PluginPage'))} />
                        <Route exact path='/:page?/:tab?/:subtab1?/:subtab2?' component={lazy(() => import('./page/OnePage'))} />
                        <Route component={lazy(() => import('./page/NotFound/NotFound'))} />
                      </Switch>
                    </main>
                  </Suspense>
                </div>
              </div>
              <RequireLogin />
            </Router>
          }
          {
            user.state === 'nobody' &&
            <Router>
              <Suspense fallback={<LinearProgress />}>
                <Switch>
                  <Route path='/install' component={lazy(() => import('./page/Install/Install'))} />
                  <Route component={lazy(() => import('./page/login/Login'))} />
                </Switch>
              </Suspense>
            </Router>
          }
        </div>
      </SnackbarProvider>
    </ThemeProvider>
  );

}

export default App;
