import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/components/header.scss';
import './styles/components/navbar.scss';
import './styles/components/searchbar.scss';
import './styles/components/toggle.scss';

import './styles/dashboard/dashboard.scss';
import './styles/dashboard/dashboard-admin.scss';

import './styles/event/event-index.scss';
import './styles/event/event-new.scss';

import './styles/forms/event-add.scss';
import './styles/forms/global.scss';
import './styles/forms/register.scss';
import './styles/forms/login.scss';

import './styles/game/game-add.scss';
import './styles/game/game-index.scss';
import './styles/game/game-scores.scss';
import './styles/game/game-show.scss';

import './styles/main/app.scss';
import './styles/main/desktop.scss';
import './styles/main/reset.scss';

import './styles/gamePlayed.scss';
import './styles/leaderboard.scss';

// start the Stimulus application
import './bootstrap';
