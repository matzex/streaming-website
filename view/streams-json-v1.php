<?php

header('Content-Type: application/json');

if($conference->isClosed())
{
	echo '{}';
	return;
}

$overview = new Overview();

$struct = array();
foreach($overview->getGroups() as $group => $rooms)
{
	foreach($rooms as $room)
	{
		$streams = array();
		foreach($room->getStreams() as $stream)
		{
			$key = $stream->getSelection().'-'.$stream->getLanguage();

			$urls = array();
			switch($stream->getPlayerType())
			{
				case 'video':
					foreach ($stream->getVideoProtos() as $proto => $display)
					{
						$urls[$proto] = array(
							'display' => $display,
							'tech' => $stream->getVideoTech($proto),
							'url' => $stream->getVideoUrl($proto),
						);
					}
					break;

				case 'slides':
					foreach ($stream->getSlidesProtos() as $proto => $display)
					{
						$urls[$proto] = array(
							'display' => $display,
							'tech' => $stream->getSlidesTech($proto),
							'url' => $stream->getSlidesUrl($proto),
						);
					}
					break;

				case 'audio':
					foreach ($stream->getAudioProtos() as $proto => $display)
					{
						$urls[$proto] = array(
							'display' => $display,
							'tech' => $stream->getAudioTech($proto),
							'url' => $stream->getAudioUrl($proto),
						);
					}
					break;

				case 'music':
					foreach ($stream->getMusicProtos() as $proto => $display)
					{
						$urls[$proto] = array(
							'display' => $display,
							'tech' => $stream->getMusicTech($proto),
							'url' => $stream->getMusicUrl($proto),
						);
					}
					break;
			}

			$streams[$key] = array(
				'display' => $stream->getDisplay(),
				'type' => $stream->getPlayerType(),
				'isTranslated' => $stream->isTranslated(),
				'videoSize' => $stream->getVideoSize(),
				'urls' => $urls,
			);
		}

		$struct[$group][$room->getSlug()] = array(
			'display' => $room->getDisplay(),
			'streams' => $streams,
		);
	}
}

echo json_encode($struct, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);