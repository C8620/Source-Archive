let vo_domain = 'https://voice.example.com'; // Change this to your voice website's domain
let err_msg_p = '尝试播放音频时出现错误：'; // Change this to your error message prefix
let err_msg_s = '请尝试刷新页面，如果此问题持续，请通过页脚链接联系我们。'; // Change this to your error message suffix

let currentAudio = null; // Global variable to keep track of the currently playing audio

function playVoice(id, ts, tkt, errr) {
    // 1. Pause any currently playing audio
    if (currentAudio) {
        currentAudio.pause();
        currentAudio = null; // Reset the currentAudio to null after pausing
    }

    // 2. Form the URL and obtain the audio file
    const url = `${vo_domain}?id=${id}&ts=${ts}&tkt=${tkt}`;

    // 3. Create a new Audio object
    const newAudio = new Audio(url);

    // 4. Play the new audio
    newAudio.play()
        .then(() => {

            // Update the currently playing audio
            currentAudio = newAudio;

            // Optional: Add an event listener to handle when the audio ends naturally
            currentAudio.addEventListener('ended', () => {
                currentAudio = null;
            });
        })
        .catch((error) => {
            // Handle errors during playback
            if (errr) {
                alert(err_msg_p + error.message + err_msg_s);
            }
        });
}