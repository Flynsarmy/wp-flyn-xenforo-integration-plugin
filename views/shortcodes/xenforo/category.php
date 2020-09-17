<table class='xenforo-category' border="0" cellspacing="0" cellpadding="0">
    <thead>
        <tr>
            <th colspan="2">
                <h2 class="entry-title">
                    <?= $the_node['node']['title'] ?>
                </h2>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($childNodes as $childNode): ?>
        <tr>
            <td class="node">
                <h4><a href="<?= $baseUrl ?>forums/<?= sanitize_title($childNode['node']['title']) ?>.<?= $childNode['node']['node_id'] ?>"><?= $childNode['node']['title'] ?></a></h4>
                <div class="description"><?= $childNode['node']['description'] ?></div>
                <div class="meta">
                    Threads: <span><?= Flyn\Xenforo\Helpers::numberConverter($childNode['node']['type_data']['discussion_count']) ?></span>,
                    Messages: <span><?= Flyn\Xenforo\Helpers::numberConverter($childNode['node']['type_data']['message_count']) ?></span>
                </div>
            </td>
            <td class="last-thread" width="250">
                <div class="title">
                    <a href="<?= $baseUrl ?>threads/<?= $childNode['node']['type_data']['last_thread_id'] ?>/post-<?= $childNode['node']['type_data']['last_post_id'] ?>">
                        <?= $childNode['node']['type_data']['last_thread_title'] ?>
                    </a>
                </div>
                <ul class="meta">
                    <li class="time">
                        <?= human_time_diff($childNode['node']['type_data']['last_post_date']) ?> ago
                    </li>
                    <li class="user">
                        <?= $childNode['node']['type_data']['last_post_username'] ?>
                    </li>
                </ul>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>